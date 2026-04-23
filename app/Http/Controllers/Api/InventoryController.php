<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:255',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = $this->inventoryQuery($filters);
        $perPage = $filters['per_page'] ?? 20;

        return response()->json(
            $query
                ->latest()
                ->paginate($perPage)
                ->appends($request->query())
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'batch_number' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'manufacturing_date' => 'nullable|date',
            'location_in_warehouse' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $inventory = DB::transaction(function () use ($data, $request) {
            $inventory = Inventory::create($data);
            $this->syncProductStock($inventory->product_id);
            $this->createTransaction($inventory, 'in', $inventory->quantity, $inventory->unit_cost, $request->user()?->id, 'Initial stock entry');
            return $inventory;
        });

        return response()->json([
            'message' => 'Inventory item created successfully',
            'inventory' => $inventory->load(['product', 'warehouse', 'supplier']),
        ], 201);
    }

    public function show(Inventory $inventory)
    {
        return response()->json($inventory->load(['product.category', 'warehouse', 'supplier']));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'warehouse_id' => 'sometimes|exists:warehouses,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'batch_number' => 'nullable|string|max:100',
            'quantity' => 'sometimes|integer|min:0',
            'unit_cost' => 'sometimes|numeric|min:0',
            'selling_price' => 'sometimes|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'manufacturing_date' => 'nullable|date',
            'location_in_warehouse' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $oldQuantity = $inventory->quantity;

        DB::transaction(function () use ($inventory, $data, $oldQuantity, $request) {
            $inventory->update($data);

            if (array_key_exists('quantity', $data) && $data['quantity'] !== $oldQuantity) {
                $delta = $data['quantity'] - $oldQuantity;
                if ($delta !== 0) {
                    $this->createTransaction(
                        $inventory,
                        'adjustment',
                        abs($delta),
                        $inventory->unit_cost,
                        $request->user()?->id,
                        'Inventory quantity adjusted'
                    );
                }
            }

            $this->syncProductStock($inventory->product_id);
        });

        return response()->json([
            'message' => 'Inventory updated successfully',
            'inventory' => $inventory->fresh(['product', 'warehouse', 'supplier']),
        ]);
    }

    public function destroy(Inventory $inventory)
    {
        DB::transaction(function () use ($inventory) {
            $productId = $inventory->product_id;
            $inventory->delete();
            $this->syncProductStock($productId);
        });

        return response()->json(['message' => 'Inventory deleted successfully']);
    }

    public function adjustStock(Request $request)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($data['inventory_id']);

        DB::transaction(function () use ($inventory, $data, $request) {
            $previous = $inventory->quantity;

            if ($data['adjustment_type'] === 'add') {
                $inventory->quantity += $data['quantity'];
            } elseif ($data['adjustment_type'] === 'subtract') {
                $inventory->quantity = max(0, $inventory->quantity - $data['quantity']);
            } else {
                $inventory->quantity = $data['quantity'];
            }

            $inventory->save();

            $delta = abs($inventory->quantity - $previous);
            if ($delta > 0) {
                $this->createTransaction(
                    $inventory,
                    'adjustment',
                    $delta,
                    $inventory->unit_cost,
                    $request->user()?->id,
                    $data['notes'] ?? 'Manual stock adjustment'
                );
            }

            $this->syncProductStock($inventory->product_id);
        });

        return response()->json([
            'message' => 'Stock adjusted successfully',
            'inventory' => $inventory->fresh(['product', 'warehouse']),
        ]);
    }

    public function transferStock(Request $request)
    {
        $data = $request->validate([
            'inventory_id' => 'required|exists:inventory,id',
            'to_warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $source = Inventory::findOrFail($data['inventory_id']);

        if ($source->warehouse_id == $data['to_warehouse_id']) {
            return response()->json(['message' => 'Source and destination warehouses must be different'], 422);
        }

        if ($source->quantity < $data['quantity']) {
            return response()->json(['message' => 'Insufficient stock for transfer'], 422);
        }

        DB::transaction(function () use ($source, $data, $request) {
            $source->quantity -= $data['quantity'];
            $source->save();

            $destination = Inventory::firstOrCreate(
                [
                    'product_id' => $source->product_id,
                    'warehouse_id' => $data['to_warehouse_id'],
                    'batch_number' => $source->batch_number,
                ],
                [
                    'supplier_id' => $source->supplier_id,
                    'quantity' => 0,
                    'unit_cost' => $source->unit_cost,
                    'selling_price' => $source->selling_price,
                    'expiry_date' => $source->expiry_date,
                    'manufacturing_date' => $source->manufacturing_date,
                    'location_in_warehouse' => null,
                    'status' => 'available',
                    'notes' => 'Auto-created from transfer',
                ]
            );

            $destination->quantity += $data['quantity'];
            $destination->save();

            $note = $data['notes'] ?? 'Warehouse transfer';
            $this->createTransaction($source, 'transfer', $data['quantity'], $source->unit_cost, $request->user()?->id, 'OUT: ' . $note);
            $this->createTransaction($destination, 'transfer', $data['quantity'], $destination->unit_cost, $request->user()?->id, 'IN: ' . $note);
            $this->syncProductStock($source->product_id);
        });

        return response()->json(['message' => 'Stock transferred successfully']);
    }

    public function lowStockReport()
    {
        $products = Product::with(['category', 'supplier'])
            ->whereRaw('current_stock <= reorder_point')
            ->orderByRaw('(reorder_point - current_stock) DESC')
            ->get();

        return response()->json(['products' => $products]);
    }

    public function summary(Request $request)
    {
        $filters = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:255',
            'days' => 'nullable|integer|min:1|max:365',
        ]);

        $days = $filters['days'] ?? 30;
        $cutoffDate = now()->addDays($days)->toDateString();
        $query = $this->inventoryQuery($filters, false);

        $statusBreakdown = (clone $query)
            ->selectRaw('status, COUNT(*) as total_batches, COALESCE(SUM(quantity), 0) as total_units')
            ->groupBy('status')
            ->orderBy('status')
            ->get()
            ->map(fn ($row) => [
                'status' => $row->status ?: 'unknown',
                'total_batches' => (int) ($row->total_batches ?? 0),
                'total_units' => (int) ($row->total_units ?? 0),
            ])
            ->values();

        return response()->json([
            'within_days' => $days,
            'cutoff_date' => $cutoffDate,
            'warehouse_id' => isset($filters['warehouse_id']) ? (int) $filters['warehouse_id'] : null,
            'total_batches' => (int) ((clone $query)->count()),
            'total_units' => (int) ((clone $query)->sum('quantity')),
            'inventory_value' => round((float) ((clone $query)->selectRaw('COALESCE(SUM(quantity * unit_cost), 0) as total')->value('total')), 2),
            'retail_value' => round((float) ((clone $query)->selectRaw('COALESCE(SUM(quantity * selling_price), 0) as total')->value('total')), 2),
            'active_products' => (int) ((clone $query)->where('quantity', '>', 0)->distinct('product_id')->count('product_id')),
            'low_stock_products' => $this->lowStockProductCount($filters),
            'expiring_batches' => (int) ((clone $query)
                ->where('quantity', '>', 0)
                ->whereNotNull('expiry_date')
                ->whereDate('expiry_date', '<=', $cutoffDate)
                ->count()),
            'zero_stock_batches' => (int) ((clone $query)->where('quantity', '<=', 0)->count()),
            'status_breakdown' => $statusBreakdown,
        ]);
    }

    public function warehouseSummary(Request $request)
    {
        $filters = $request->validate([
            'status' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:255',
            'days' => 'nullable|integer|min:1|max:365',
        ]);

        $days = $filters['days'] ?? 30;
        $cutoffDate = now()->addDays($days)->toDateString();
        $search = trim((string) ($filters['search'] ?? ''));

        $items = Inventory::query()
            ->join('warehouses', 'warehouses.id', '=', 'inventory.warehouse_id')
            ->leftJoin('branches', 'branches.id', '=', 'warehouses.branch_id')
            ->when(!empty($filters['status']), fn ($query) => $query->where('inventory.status', $filters['status']))
            ->when($search !== '', function ($query) use ($search) {
                $term = '%' . $search . '%';
                $query->where(function ($inner) use ($term) {
                    $inner->where('warehouses.name', 'like', $term)
                        ->orWhere('warehouses.code', 'like', $term)
                        ->orWhere('warehouses.location', 'like', $term)
                        ->orWhere('inventory.batch_number', 'like', $term)
                        ->orWhere('inventory.location_in_warehouse', 'like', $term)
                        ->orWhereExists(function ($productQuery) use ($term) {
                            $productQuery->select(DB::raw(1))
                                ->from('products')
                                ->whereColumn('products.id', 'inventory.product_id')
                                ->where(function ($searchProducts) use ($term) {
                                    $searchProducts->where('products.name', 'like', $term)
                                        ->orWhere('products.sku', 'like', $term);
                                });
                        });
                });
            })
            ->selectRaw('
                warehouses.id as warehouse_id,
                warehouses.name as warehouse_name,
                warehouses.code as warehouse_code,
                warehouses.location as warehouse_location,
                branches.name as branch_name,
                COUNT(inventory.id) as total_batches,
                COUNT(DISTINCT inventory.product_id) as total_products,
                COALESCE(SUM(inventory.quantity), 0) as total_units,
                COALESCE(SUM(inventory.quantity * inventory.unit_cost), 0) as inventory_value,
                COALESCE(SUM(CASE WHEN inventory.quantity > 0 AND (inventory.status IS NULL OR inventory.status = "available") THEN inventory.quantity ELSE 0 END), 0) as available_units,
                COALESCE(SUM(CASE WHEN inventory.quantity <= 0 THEN 1 ELSE 0 END), 0) as empty_batches,
                COALESCE(SUM(CASE WHEN inventory.quantity > 0 AND inventory.expiry_date IS NOT NULL AND inventory.expiry_date <= ? THEN 1 ELSE 0 END), 0) as expiring_batches
            ', [$cutoffDate])
            ->groupBy('warehouses.id', 'warehouses.name', 'warehouses.code', 'warehouses.location', 'branches.name')
            ->orderBy('warehouses.name')
            ->get()
            ->map(fn ($row) => [
                'warehouse_id' => (int) $row->warehouse_id,
                'warehouse_name' => $row->warehouse_name,
                'warehouse_code' => $row->warehouse_code,
                'warehouse_location' => $row->warehouse_location,
                'branch_name' => $row->branch_name,
                'total_batches' => (int) ($row->total_batches ?? 0),
                'total_products' => (int) ($row->total_products ?? 0),
                'total_units' => (int) ($row->total_units ?? 0),
                'available_units' => (int) ($row->available_units ?? 0),
                'empty_batches' => (int) ($row->empty_batches ?? 0),
                'expiring_batches' => (int) ($row->expiring_batches ?? 0),
                'inventory_value' => round((float) ($row->inventory_value ?? 0), 2),
            ])
            ->values();

        return response()->json([
            'within_days' => $days,
            'cutoff_date' => $cutoffDate,
            'items' => $items,
        ]);
    }

    public function batches(Request $request)
    {
        $filters = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:255',
            'per_page' => 'nullable|integer|min:1|max:100',
            'sort_by' => 'nullable|in:created_at,expiry_date,manufacturing_date,quantity,status',
            'sort_dir' => 'nullable|in:asc,desc',
        ]);

        $sortBy = $filters['sort_by'] ?? 'expiry_date';
        $sortDir = $filters['sort_dir'] ?? ($sortBy === 'quantity' ? 'desc' : 'asc');
        $perPage = $filters['per_page'] ?? 25;

        $items = $this->inventoryQuery($filters)
            ->orderBy($sortBy, $sortDir)
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->appends($request->query());

        $items->getCollection()->transform(function (Inventory $inventory) {
            return array_merge($inventory->toArray(), $this->formatInventoryMetrics($inventory));
        });

        return response()->json($items);
    }

    public function aging(Request $request)
    {
        $filters = $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'nullable|string|max:50',
            'search' => 'nullable|string|max:255',
            'threshold_days' => 'nullable|integer|min:31|max:3650',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $thresholdDays = $filters['threshold_days'] ?? 90;
        $perPage = $filters['per_page'] ?? 20;
        $ageExpression = 'DATEDIFF(CURDATE(), COALESCE(inventory.manufacturing_date, DATE(inventory.created_at)))';

        $query = $this->inventoryQuery($filters)
            ->where('quantity', '>', 0)
            ->select('inventory.*')
            ->selectRaw("{$ageExpression} as age_days");

        $items = $query
            ->orderByDesc('age_days')
            ->orderBy('expiry_date')
            ->paginate($perPage)
            ->appends($request->query());

        $items->getCollection()->transform(function (Inventory $inventory) use ($thresholdDays) {
            $metrics = $this->formatInventoryMetrics($inventory);
            $ageDays = (int) ($metrics['age_days'] ?? 0);
            $metrics['age_flag'] = $ageDays > $thresholdDays ? 'aging' : ($ageDays > 30 ? 'monitor' : 'fresh');
            return array_merge($inventory->toArray(), $metrics);
        });

        $baseQuery = $this->inventoryQuery($filters, false)->where('quantity', '>', 0);

        return response()->json([
            'threshold_days' => $thresholdDays,
            'average_age_days' => round((float) ((clone $baseQuery)->selectRaw("COALESCE(AVG({$ageExpression}), 0) as average_age_days")->value('average_age_days')), 1),
            'buckets' => [
                'fresh' => (int) ((clone $baseQuery)->whereRaw("{$ageExpression} BETWEEN 0 AND 30")->count()),
                'monitor' => (int) ((clone $baseQuery)->whereRaw("{$ageExpression} BETWEEN 31 AND ?", [$thresholdDays])->count()),
                'aging' => (int) ((clone $baseQuery)->whereRaw("{$ageExpression} > ?", [$thresholdDays])->count()),
            ],
            'items' => $items,
        ]);
    }

    public function expiringSoon(Request $request)
    {
        $data = $request->validate([
            'days' => 'nullable|integer|min:1|max:365',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $days = $data['days'] ?? 30;
        $cutoffDate = now()->addDays($days)->toDateString();
        $perPage = $data['per_page'] ?? 20;

        $query = Inventory::with(['product.category', 'warehouse', 'supplier'])
            ->where('quantity', '>', 0)
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $cutoffDate)
            ->orderBy('expiry_date');

        if (!empty($data['warehouse_id'])) {
            $query->where('warehouse_id', $data['warehouse_id']);
        }

        return response()->json([
            'within_days' => $days,
            'cutoff_date' => $cutoffDate,
            'items' => $query->paginate($perPage)->appends($request->query()),
        ]);
    }

    public function updateStatus(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'status' => 'required|string|max:50',
            'location_in_warehouse' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $existingNotes = trim((string) ($inventory->notes ?? ''));
        $statusNote = trim((string) ($data['notes'] ?? ''));

        $payload = [
            'status' => $data['status'],
        ];

        if (array_key_exists('location_in_warehouse', $data)) {
            $payload['location_in_warehouse'] = $data['location_in_warehouse'];
        }

        if ($statusNote !== '') {
            $entry = '[' . now()->format('Y-m-d H:i') . "] Status update: {$statusNote}";
            $payload['notes'] = $existingNotes !== '' ? ($existingNotes . PHP_EOL . $entry) : $entry;
        }

        $inventory->update($payload);

        return response()->json([
            'message' => 'Inventory status updated successfully',
            'inventory' => $inventory->fresh(['product.category', 'warehouse', 'supplier']),
        ]);
    }

    private function syncProductStock(int $productId): void
    {
        $total = Inventory::where('product_id', $productId)->sum('quantity');
        Product::where('id', $productId)->update(['current_stock' => $total]);
    }

    private function createTransaction(Inventory $inventory, string $type, int $qty, string|float $unitPrice, ?int $userId, string $notes): void
    {
        Transaction::create([
            'transaction_number' => 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
            'product_id' => $inventory->product_id,
            'inventory_id' => $inventory->id,
            'transaction_type' => $type,
            'quantity' => $qty,
            'unit_price' => $unitPrice,
            'total_amount' => $qty * (float) $unitPrice,
            'warehouse_id' => $inventory->warehouse_id,
            'user_id' => $userId,
            'supplier_id' => $inventory->supplier_id,
            'notes' => $notes,
        ]);
    }

    private function inventoryQuery(array $filters = [], bool $withRelations = true): Builder
    {
        $query = Inventory::query();

        if ($withRelations) {
            $query->with(['product.category', 'warehouse', 'supplier']);
        }

        if (!empty($filters['warehouse_id'])) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }

        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $term = $filters['search'];

            $query->where(function ($nested) use ($term) {
                $nested->where('batch_number', 'like', '%' . $term . '%')
                    ->orWhere('location_in_warehouse', 'like', '%' . $term . '%')
                    ->orWhere('status', 'like', '%' . $term . '%')
                    ->orWhereHas('product', function ($productQuery) use ($term) {
                        $productQuery->where('name', 'like', '%' . $term . '%')
                            ->orWhere('sku', 'like', '%' . $term . '%');
                    })
                    ->orWhereHas('warehouse', function ($warehouseQuery) use ($term) {
                        $warehouseQuery->where('name', 'like', '%' . $term . '%')
                            ->orWhere('code', 'like', '%' . $term . '%');
                    })
                    ->orWhereHas('supplier', function ($supplierQuery) use ($term) {
                        $supplierQuery->where('name', 'like', '%' . $term . '%');
                    });
            });
        }

        return $query;
    }

    private function lowStockProductCount(array $filters = []): int
    {
        $groupedStock = $this->inventoryQuery($filters, false)
            ->join('products', 'products.id', '=', 'inventory.product_id')
            ->selectRaw('inventory.product_id, COALESCE(SUM(inventory.quantity), 0) as total_quantity, COALESCE(products.reorder_point, 0) as reorder_point')
            ->groupBy('inventory.product_id', 'products.reorder_point');

        return DB::query()
            ->fromSub($groupedStock, 'product_stock_levels')
            ->whereColumn('total_quantity', '<=', 'reorder_point')
            ->count();
    }

    private function formatInventoryMetrics(Inventory $inventory): array
    {
        $baseDate = $inventory->manufacturing_date ?? $inventory->created_at;
        $ageDays = $baseDate ? $baseDate->copy()->startOfDay()->diffInDays(now()->startOfDay()) : null;
        $daysToExpiry = $inventory->expiry_date
            ? now()->startOfDay()->diffInDays($inventory->expiry_date->copy()->startOfDay(), false)
            : null;

        return [
            'age_days' => $ageDays,
            'days_to_expiry' => $daysToExpiry,
            'stock_value' => round((float) $inventory->quantity * (float) $inventory->unit_cost, 2),
            'retail_value' => round((float) $inventory->quantity * (float) $inventory->selling_price, 2),
            'inventory_health' => $this->inventoryHealthStatus($inventory, $daysToExpiry, $ageDays),
        ];
    }

    private function inventoryHealthStatus(Inventory $inventory, ?int $daysToExpiry, ?int $ageDays): string
    {
        if ((int) $inventory->quantity <= 0) {
            return 'depleted';
        }

        if ($daysToExpiry !== null && $daysToExpiry < 0) {
            return 'expired';
        }

        if ($daysToExpiry !== null && $daysToExpiry <= 30) {
            return 'expiring';
        }

        if ($ageDays !== null && $ageDays > 90) {
            return 'aging';
        }

        return 'healthy';
    }
}
