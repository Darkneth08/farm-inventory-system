<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['product', 'inventory', 'warehouse', 'user', 'supplier'])
            ->latest();

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        return response()->json($query->paginate(25));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'inventory_id' => 'nullable|exists:inventory,id',
            'transaction_type' => 'required|in:in,out,adjustment,transfer',
            'adjustment_type' => 'nullable|in:increase,decrease|required_if:transaction_type,adjustment',
            'adjustment_reason' => 'nullable|in:damaged,expired,correction,other|required_if:transaction_type,adjustment',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            $transaction = DB::transaction(function () use ($data, $request) {
                $transactionType = (string) $data['transaction_type'];
                $inventory = $this->resolveInventoryForMovement($data);

                if (in_array($transactionType, ['in', 'out'], true) && !$inventory && empty($data['warehouse_id'])) {
                    throw new \RuntimeException('Warehouse is required for stock in/out transactions.');
                }

                if ($transactionType === 'in') {
                    if (!$inventory) {
                        $inventory = $this->createInventoryForStockIn($data);
                    }

                    $inventory->quantity = (int) $inventory->quantity + (int) $data['quantity'];
                    $inventory->unit_cost = (float) $data['unit_price'];
                    if ((float) ($inventory->selling_price ?? 0) <= 0) {
                        $inventory->selling_price = (float) $data['unit_price'];
                    }
                    if (!empty($data['supplier_id'])) {
                        $inventory->supplier_id = $data['supplier_id'];
                    }
                    $inventory->save();
                } elseif ($transactionType === 'out') {
                    if (!$inventory) {
                        throw new \RuntimeException('No inventory found for the selected product and warehouse. Do stock in first.');
                    }
                    if ((int) $inventory->quantity < (int) $data['quantity']) {
                        throw new \RuntimeException('Insufficient stock for stock out. Available: ' . (int) $inventory->quantity);
                    }

                    $inventory->quantity = (int) $inventory->quantity - (int) $data['quantity'];
                    $inventory->save();
                } elseif ($transactionType === 'adjustment') {
                    $adjustmentType = (string) ($data['adjustment_type'] ?? 'decrease');
                    $adjustmentReason = (string) ($data['adjustment_reason'] ?? 'correction');

                    if (!$inventory && $adjustmentType === 'increase') {
                        $inventory = $this->createInventoryForStockIn($data);
                    }
                    if (!$inventory) {
                        throw new \RuntimeException('No inventory found for adjustment. Do stock in first or select an existing inventory record.');
                    }

                    if ($adjustmentType === 'decrease' && (int) $inventory->quantity < (int) $data['quantity']) {
                        throw new \RuntimeException('Insufficient stock for adjustment. Available: ' . (int) $inventory->quantity);
                    }

                    if ($adjustmentType === 'increase') {
                        $inventory->quantity = (int) $inventory->quantity + (int) $data['quantity'];
                    } else {
                        $inventory->quantity = (int) $inventory->quantity - (int) $data['quantity'];
                    }

                    $inventory->save();
                }

                $transactionNotes = $data['notes'] ?? null;
                if ($transactionType === 'adjustment') {
                    $adjustmentType = (string) ($data['adjustment_type'] ?? 'decrease');
                    $adjustmentReason = (string) ($data['adjustment_reason'] ?? 'correction');
                    $prefix = 'Adjustment (' . $adjustmentType . ') | Reason: ' . $adjustmentReason;
                    $transactionNotes = $transactionNotes ? ($prefix . ' | ' . $transactionNotes) : $prefix;
                }

                $totalAmount = (float) $data['quantity'] * (float) $data['unit_price'];
                if ($transactionType === 'adjustment' && (($data['adjustment_type'] ?? 'decrease') === 'decrease')) {
                    $totalAmount *= -1;
                }

                $transaction = Transaction::create([
                    'transaction_number' => 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                    'product_id' => $data['product_id'],
                    'inventory_id' => $inventory?->id ?? $data['inventory_id'] ?? null,
                    'transaction_type' => $transactionType,
                    'quantity' => $data['quantity'],
                    'unit_price' => $data['unit_price'],
                    'total_amount' => $totalAmount,
                    'warehouse_id' => $data['warehouse_id'] ?? $inventory?->warehouse_id,
                    'user_id' => $request->user()?->id,
                    'supplier_id' => $data['supplier_id'] ?? $inventory?->supplier_id,
                    'reference_number' => $data['reference_number'] ?? null,
                    'notes' => $transactionNotes,
                ]);

                $total = Inventory::where('product_id', $data['product_id'])->sum('quantity');
                Product::where('id', $data['product_id'])->update(['current_stock' => $total]);

                return $transaction;
            });
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Transaction created successfully',
            'transaction' => $transaction->load(['product', 'warehouse', 'user', 'supplier']),
        ], 201);
    }

    private function resolveInventoryForMovement(array $data): ?Inventory
    {
        if (!empty($data['inventory_id'])) {
            $inventory = Inventory::query()->lockForUpdate()->find($data['inventory_id']);
            if (!$inventory) {
                return null;
            }

            if ((int) $inventory->product_id !== (int) $data['product_id']) {
                throw new \RuntimeException('Selected inventory does not match the selected product.');
            }

            if (!empty($data['warehouse_id']) && (int) $inventory->warehouse_id !== (int) $data['warehouse_id']) {
                throw new \RuntimeException('Selected inventory does not belong to the selected warehouse.');
            }

            return $inventory;
        }

        if (empty($data['warehouse_id'])) {
            return null;
        }

        $query = Inventory::query()
            ->where('product_id', $data['product_id'])
            ->where('warehouse_id', $data['warehouse_id'])
            ->orderByRaw('batch_number IS NULL DESC')
            ->orderBy('id')
            ->lockForUpdate();

        if (!empty($data['supplier_id'])) {
            $query->where('supplier_id', $data['supplier_id']);
        }

        return $query->first();
    }

    private function createInventoryForStockIn(array $data): Inventory
    {
        if (empty($data['warehouse_id'])) {
            throw new \RuntimeException('Warehouse is required for stock in.');
        }

        $product = Product::query()
            ->select(['id', 'unit_price'])
            ->findOrFail($data['product_id']);

        $defaultSellingPrice = (float) ($product->unit_price ?? 0);
        if ($defaultSellingPrice <= 0) {
            $defaultSellingPrice = (float) $data['unit_price'];
        }

        return Inventory::create([
            'product_id' => $data['product_id'],
            'warehouse_id' => $data['warehouse_id'],
            'supplier_id' => $data['supplier_id'] ?? null,
            'batch_number' => null,
            'quantity' => 0,
            'unit_cost' => (float) $data['unit_price'],
            'selling_price' => $defaultSellingPrice,
            'expiry_date' => null,
            'manufacturing_date' => null,
            'location_in_warehouse' => null,
            'status' => 'available',
            'notes' => null,
        ]);
    }

    public function show(Transaction $transaction)
    {
        return response()->json($transaction->load(['product', 'inventory', 'warehouse', 'user', 'supplier']));
    }

    public function summary(Request $request)
    {
        $data = $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'type' => 'nullable|in:in,out,adjustment,transfer',
            'group_by' => 'nullable|in:day,week,month',
        ]);

        $from = isset($data['from']) ? now()->parse($data['from'])->startOfDay() : now()->startOfMonth()->startOfDay();
        $to = isset($data['to']) ? now()->parse($data['to'])->endOfDay() : now()->endOfMonth()->endOfDay();

        if ($to->lt($from)) {
            return response()->json([
                'message' => 'The "to" date must be greater than or equal to the "from" date.',
            ], 422);
        }

        $query = Transaction::query()->whereBetween('created_at', [$from, $to]);

        if (!empty($data['type'])) {
            $query->where('transaction_type', $data['type']);
        }

        $byType = (clone $query)
            ->selectRaw('transaction_type, COUNT(*) as total_transactions, SUM(quantity) as total_quantity, SUM(total_amount) as total_amount')
            ->groupBy('transaction_type')
            ->orderBy('transaction_type')
            ->get();

        $groupBy = $data['group_by'] ?? 'day';
        $bucketExpr = match ($groupBy) {
            'week' => "DATE_FORMAT(created_at, '%x-W%v')",
            'month' => "DATE_FORMAT(created_at, '%Y-%m')",
            default => 'DATE(created_at)',
        };

        $trend = (clone $query)
            ->selectRaw("$bucketExpr as bucket, SUM(quantity) as total_quantity, SUM(total_amount) as total_amount")
            ->groupBy(DB::raw($bucketExpr))
            ->orderBy('bucket')
            ->get();

        return response()->json([
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'filter_type' => $data['type'] ?? null,
            'group_by' => $groupBy,
            'totals' => [
                'transactions' => (int) (clone $query)->count(),
                'quantity' => (int) (clone $query)->sum('quantity'),
                'amount' => (float) (clone $query)->sum('total_amount'),
            ],
            'by_type' => $byType,
            'trend' => $trend,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $transaction->update($data);

        return response()->json([
            'message' => 'Transaction updated successfully',
            'transaction' => $transaction->fresh(['product', 'warehouse', 'user', 'supplier']),
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully']);
    }
}

