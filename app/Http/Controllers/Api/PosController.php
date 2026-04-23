<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function catalog(Request $request)
    {
        $data = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'search' => 'nullable|string|max:255',
        ]);

        $warehouseId = (int) $data['warehouse_id'];
        $search = trim((string) ($data['search'] ?? ''));

        $warehouse = Warehouse::query()
            ->with('branch:id,name,code')
            ->findOrFail($warehouseId, ['id', 'branch_id', 'name', 'code', 'location', 'is_active']);

        $items = Product::query()
            ->leftJoin('inventory', function ($join) use ($warehouseId) {
                $join->on('inventory.product_id', '=', 'products.id')
                    ->where('inventory.warehouse_id', '=', $warehouseId);
            })
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.is_active', true)
            ->when($search !== '', function ($query) use ($search) {
                $term = '%' . $search . '%';
                $query->where(function ($inner) use ($term) {
                    $inner->where('products.name', 'like', $term)
                        ->orWhere('products.sku', 'like', $term)
                        ->orWhere('categories.name', 'like', $term);
                });
            })
            ->select([
                'products.id',
                'products.name',
                'products.sku',
                'products.unit_price',
                'products.unit_of_measure',
                'products.reorder_point',
                'products.is_active',
                'categories.name as category_name',
            ])
            ->selectRaw('COALESCE(SUM(CASE WHEN inventory.quantity > 0 AND (inventory.status IS NULL OR inventory.status = "available") THEN inventory.quantity ELSE 0 END), 0) as available_stock')
            ->selectRaw('COALESCE(SUM(CASE WHEN inventory.quantity > 0 THEN inventory.quantity ELSE 0 END), 0) as total_stock')
            ->selectRaw('COUNT(DISTINCT inventory.id) as batch_count')
            ->selectRaw('MIN(CASE WHEN inventory.quantity > 0 AND inventory.expiry_date IS NOT NULL THEN inventory.expiry_date END) as nearest_expiry_date')
            ->groupBy([
                'products.id',
                'products.name',
                'products.sku',
                'products.unit_price',
                'products.unit_of_measure',
                'products.reorder_point',
                'products.is_active',
                'categories.name',
            ])
            ->orderByDesc('available_stock')
            ->orderBy('products.name')
            ->get()
            ->map(function ($row) {
                $availableStock = (int) ($row->available_stock ?? 0);
                $reorderPoint = (int) ($row->reorder_point ?? 0);
                return [
                    'id' => (int) $row->id,
                    'name' => $row->name,
                    'sku' => $row->sku,
                    'unit_price' => round((float) ($row->unit_price ?? 0), 2),
                    'unit_of_measure' => $row->unit_of_measure,
                    'reorder_point' => $reorderPoint,
                    'is_active' => (bool) $row->is_active,
                    'category_name' => $row->category_name,
                    'available_stock' => $availableStock,
                    'total_stock' => (int) ($row->total_stock ?? 0),
                    'batch_count' => (int) ($row->batch_count ?? 0),
                    'nearest_expiry_date' => $row->nearest_expiry_date,
                    'stock_status' => $availableStock <= 0
                        ? 'out_of_stock'
                        : ($availableStock <= $reorderPoint ? 'low_stock' : 'in_stock'),
                ];
            })
            ->values();

        return response()->json([
            'warehouse' => $warehouse,
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function checkout(Request $request)
    {
        $parsedItems = $request->input('items');
        if (is_string($parsedItems)) {
            $decoded = json_decode($parsedItems, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $parsedItems = $decoded;
            }
        }

        $request->merge([
            'payment_method' => $request->input('payment_method', 'cash'),
            'discount_type' => $request->input('discount_type', 'none'),
            'items' => $parsedItems,
        ]);

        $data = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'nullable|in:cash,gcash',
            'cash_received' => 'nullable|numeric|min:0|required_if:payment_method,cash',
            'gcash_reference_number' => 'nullable|string|max:255|required_if:payment_method,gcash',
            'gcash_receipt' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120|required_if:payment_method,gcash',
            'discount_type' => 'nullable|in:none,senior,pwd',
            'discount_id_number' => 'nullable|string|max:100|required_if:discount_type,senior,pwd',
            'discount_id_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120|required_if:discount_type,senior,pwd',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1|max:100',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'nullable|numeric|min:0',
        ]);

        $gcashReceiptPath = null;
        if ($data['payment_method'] === 'gcash' && $request->hasFile('gcash_receipt')) {
            $gcashReceiptPath = $request->file('gcash_receipt')->store('gcash-receipts', 'public');
        }

        $discountType = strtolower((string) ($data['discount_type'] ?? 'none'));
        if (!in_array($discountType, ['none', 'senior', 'pwd'], true)) {
            $discountType = 'none';
        }

        $discountIdImagePath = null;
        if (in_array($discountType, ['senior', 'pwd'], true) && $request->hasFile('discount_id_image')) {
            $discountIdImagePath = $request->file('discount_id_image')->store('discount-id-proofs', 'public');
        }

        try {
            $sale = DB::transaction(function () use ($data, $request, $gcashReceiptPath, $discountIdImagePath, $discountType) {
                $saleNumber = 'POS-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));
                $warehouseId = (int) $data['warehouse_id'];
                $requestedDiscount = round((float) ($data['discount'] ?? 0), 2);

                $groupedItems = [];
                foreach ($data['items'] as $item) {
                    $productId = (int) $item['product_id'];
                    $qty = (int) $item['quantity'];

                    if (!isset($groupedItems[$productId])) {
                        $groupedItems[$productId] = [
                            'product_id' => $productId,
                            'quantity' => 0,
                            'unit_price' => array_key_exists('unit_price', $item) ? (float) $item['unit_price'] : null,
                        ];
                    }

                    $groupedItems[$productId]['quantity'] += $qty;
                    if (array_key_exists('unit_price', $item) && $item['unit_price'] !== null) {
                        $groupedItems[$productId]['unit_price'] = (float) $item['unit_price'];
                    }
                }

                $subtotal = 0.0;
                $totalItems = 0;
                $lines = [];

                foreach (array_values($groupedItems) as $item) {
                    $product = Product::findOrFail($item['product_id']);

                    if (!$product->is_active) {
                        throw new \RuntimeException("{$product->name} is inactive and cannot be sold.");
                    }

                    $inventoryBatches = Inventory::query()
                        ->where('product_id', $product->id)
                        ->where('warehouse_id', $warehouseId)
                        ->where('quantity', '>', 0)
                        ->where(function ($query) {
                            $query->whereNull('status')
                                ->orWhere('status', 'available');
                        })
                        ->orderByRaw('CASE WHEN expiry_date IS NULL THEN 1 ELSE 0 END')
                        ->orderBy('expiry_date')
                        ->orderBy('id')
                        ->lockForUpdate()
                        ->get();

                    $qty = (int) $item['quantity'];
                    $availableStock = (int) $inventoryBatches->sum('quantity');
                    if ($availableStock < $qty) {
                        throw new \RuntimeException("Insufficient stock for {$product->name} in the selected warehouse.");
                    }

                    $unitPrice = round((float) ($item['unit_price'] ?? $product->unit_price), 2);
                    $lineTotal = round($qty * $unitPrice, 2);
                    $remainingToDeduct = $qty;
                    $transactionIds = [];
                    $batchBreakdown = [];

                    $notes = 'POS sale';
                    if (!empty($data['customer_name'])) {
                        $notes .= " | Customer: {$data['customer_name']}";
                    }
                    if (!empty($data['payment_method'])) {
                        $notes .= " | Payment: {$data['payment_method']}";
                    }
                    if (!empty($data['gcash_reference_number'])) {
                        $notes .= " | GCash Ref: {$data['gcash_reference_number']}";
                    }
                    if (!empty($data['notes'])) {
                        $notes .= " | Note: {$data['notes']}";
                    }

                    foreach ($inventoryBatches as $inventory) {
                        if ($remainingToDeduct <= 0) {
                            break;
                        }

                        $deductQty = min((int) $inventory->quantity, $remainingToDeduct);
                        if ($deductQty <= 0) {
                            continue;
                        }

                        $inventory->quantity -= $deductQty;
                        $inventory->save();

                        $transaction = Transaction::create([
                            'transaction_number' => 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                            'product_id' => $product->id,
                            'inventory_id' => $inventory->id,
                            'transaction_type' => 'out',
                            'quantity' => $deductQty,
                            'unit_price' => $unitPrice,
                            'total_amount' => round($deductQty * $unitPrice, 2),
                            'warehouse_id' => $warehouseId,
                            'user_id' => $request->user()?->id,
                            'supplier_id' => $inventory->supplier_id,
                            'reference_number' => $saleNumber,
                            'notes' => $notes,
                        ]);

                        $transactionIds[] = $transaction->id;
                        $batchBreakdown[] = [
                            'inventory_id' => (int) $inventory->id,
                            'batch_number' => $inventory->batch_number,
                            'quantity' => (int) $deductQty,
                            'remaining_batch_stock' => (int) $inventory->quantity,
                            'expiry_date' => $inventory->expiry_date,
                        ];

                        $remainingToDeduct -= $deductQty;
                    }

                    $updatedTotalStock = Inventory::where('product_id', $product->id)->sum('quantity');
                    Product::where('id', $product->id)->update(['current_stock' => $updatedTotalStock]);

                    $subtotal += $lineTotal;
                    $totalItems += $qty;

                    $lines[] = [
                        'transaction_id' => $transactionIds[0] ?? null,
                        'transaction_ids' => $transactionIds,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'sku' => $product->sku,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'line_total' => $lineTotal,
                        'available_before_sale' => $availableStock,
                        'remaining_warehouse_stock' => max($availableStock - $qty, 0),
                        'batch_breakdown' => $batchBreakdown,
                    ];
                }

                $subtotal = round($subtotal, 2);
                $discount = in_array($discountType, ['senior', 'pwd'], true)
                    ? round($subtotal * 0.20, 2)
                    : $requestedDiscount;
                $discount = min(max($discount, 0), $subtotal);
                $totalAmount = round($subtotal - $discount, 2);
                $paymentMethod = $data['payment_method'] ?? 'cash';
                $cashReceived = isset($data['cash_received']) ? round((float) $data['cash_received'], 2) : null;

                if ($paymentMethod === 'cash') {
                    if ($cashReceived === null) {
                        throw new \RuntimeException('Cash received is required for cash payments.');
                    }
                    if ($cashReceived < $totalAmount) {
                        throw new \RuntimeException('Cash received is less than total amount.');
                    }
                }

                $changeDue = ($paymentMethod === 'cash' && $cashReceived !== null)
                    ? round($cashReceived - $totalAmount, 2)
                    : 0.0;

                $saleNotes = $data['notes'] ?? null;
                if (in_array($discountType, ['senior', 'pwd'], true)) {
                    $discountLabel = strtoupper($discountType) . ' 20% discount';
                    $saleNotes = $saleNotes ? ($saleNotes . ' | ' . $discountLabel) : $discountLabel;
                    if (!empty($data['discount_id_number'])) {
                        $saleNotes .= " | ID No: {$data['discount_id_number']}";
                    }
                }

                $saleRecord = Sale::create([
                    'sale_number' => $saleNumber,
                    'customer_user_id' => $request->user()?->role === 'customer' ? $request->user()?->id : null,
                    'cashier_user_id' => $request->user()?->id,
                    'sold_at' => now(),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'discount_type' => $discountType,
                    'discount_id_number' => in_array($discountType, ['senior', 'pwd'], true) ? ($data['discount_id_number'] ?? null) : null,
                    'discount_id_image_path' => in_array($discountType, ['senior', 'pwd'], true) ? $discountIdImagePath : null,
                    'total' => $totalAmount,
                    'amount_paid' => $paymentMethod === 'cash' ? ($cashReceived ?? 0) : $totalAmount,
                    'change_due' => $changeDue,
                    'payment_method' => $paymentMethod,
                    'gcash_reference_number' => $paymentMethod === 'gcash' ? ($data['gcash_reference_number'] ?? null) : null,
                    'gcash_receipt_image_path' => $paymentMethod === 'gcash' ? $gcashReceiptPath : null,
                    'notes' => $saleNotes,
                ]);

                foreach ($lines as $line) {
                    SaleItem::create([
                        'sale_id' => $saleRecord->id,
                        'product_id' => $line['product_id'],
                        'quantity' => $line['quantity'],
                        'unit_price' => $line['unit_price'],
                        'line_total' => $line['line_total'],
                    ]);
                }

                if (Schema::hasColumn('transactions', 'sale_id')) {
                    $transactionIds = collect($lines)
                        ->flatMap(fn (array $line) => $line['transaction_ids'] ?? [])
                        ->filter()
                        ->values()
                        ->all();

                    if (!empty($transactionIds)) {
                        Transaction::whereIn('id', $transactionIds)->update(['sale_id' => $saleRecord->id]);
                    }
                }

                return [
                    'sale_id' => $saleRecord->id,
                    'sale_number' => $saleNumber,
                    'warehouse_id' => $warehouseId,
                    'customer_name' => $data['customer_name'] ?? null,
                    'payment_method' => $paymentMethod,
                    'discount_type' => $discountType,
                    'discount_id_number' => in_array($discountType, ['senior', 'pwd'], true) ? ($data['discount_id_number'] ?? null) : null,
                    'discount_id_image_url' => in_array($discountType, ['senior', 'pwd'], true) && $discountIdImagePath
                        ? Storage::url($discountIdImagePath)
                        : null,
                    'cash_received' => $cashReceived,
                    'gcash_reference_number' => $paymentMethod === 'gcash' ? ($data['gcash_reference_number'] ?? null) : null,
                    'gcash_receipt_image_url' => $paymentMethod === 'gcash' && $gcashReceiptPath
                        ? Storage::url($gcashReceiptPath)
                        : null,
                    'change_due' => $changeDue,
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total_amount' => $totalAmount,
                    'total_items' => $totalItems,
                    'lines' => $lines,
                ];
            });
        } catch (\RuntimeException $e) {
            if (!empty($gcashReceiptPath)) {
                Storage::disk('public')->delete($gcashReceiptPath);
            }
            if (!empty($discountIdImagePath)) {
                Storage::disk('public')->delete($discountIdImagePath);
            }
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            if (!empty($gcashReceiptPath)) {
                Storage::disk('public')->delete($gcashReceiptPath);
            }
            if (!empty($discountIdImagePath)) {
                Storage::disk('public')->delete($discountIdImagePath);
            }
            throw $e;
        }

        return response()->json([
            'message' => 'POS checkout completed successfully',
            'sale' => $sale,
        ], 201);
    }

    public function recentSales(Request $request)
    {
        $data = $request->validate([
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $limit = $data['limit'] ?? 10;

        $query = Sale::query()
            ->with(['cashier:id,name'])
            ->withSum('items as total_items', 'quantity')
            ->orderByDesc('sold_at')
            ->limit($limit);

        if ($request->user()?->role === 'customer') {
            $query->where('customer_user_id', $request->user()->id);
        }

        $sales = $query
            ->get()
            ->map(function (Sale $row) {
                return [
                    'sale_number' => $row->sale_number,
                    'warehouse_id' => null,
                    'warehouse_name' => null,
                    'cashier_name' => $row->cashier?->name,
                    'sold_at' => $row->sold_at,
                    'total_items' => (int) ($row->total_items ?? 0),
                    'total_amount' => (float) $row->total,
                    'payment_method' => $row->payment_method,
                    'discount_type' => $row->discount_type ?? 'none',
                    'gcash_reference_number' => $row->gcash_reference_number,
                ];
            })
            ->values();

        return response()->json([
            'count' => $sales->count(),
            'items' => $sales,
        ]);
    }

    public function warehouses(Request $request)
    {
        $query = Warehouse::query()->with('branch:id,name,code')->orderBy('name');

        if ($request->user()?->role !== 'super_admin') {
            $query->where('is_active', true);
        }

        $items = $query->get(['id', 'branch_id', 'name', 'code', 'location', 'is_active']);

        return response()->json([
            'count' => $items->count(),
            'items' => $items,
        ]);
    }
}
