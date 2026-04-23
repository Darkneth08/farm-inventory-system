<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockReceipt;
use App\Models\StockReceiptItem;
use App\Models\Transaction;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StockReceiptController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = StockReceipt::query()
            ->with(['supplier:id,name', 'receivedBy:id,name', 'items.product:id,name,sku'])
            ->latest('received_at');

        if (!empty($data['supplier_id'])) {
            $query->where('supplier_id', $data['supplier_id']);
        }

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reference_no' => 'nullable|string|max:255|unique:stock_receipts,reference_no',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1|max:100',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:1000000',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'items.*.batch_number' => 'nullable|string|max:100',
            'items.*.manufacturing_date' => 'nullable|date',
            'items.*.expiry_date' => 'nullable|date',
        ]);

        $receipt = DB::transaction(function () use ($data, $request) {
            $referenceNo = $data['reference_no'] ?? ('REC-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)));

            $receipt = StockReceipt::create([
                'supplier_id' => $data['supplier_id'],
                'received_by_user_id' => $request->user()->id,
                'received_at' => now(),
                'reference_no' => $referenceNo,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $row) {
                $productId = (int) $row['product_id'];
                $quantity = (int) $row['quantity'];
                $unitCost = round((float) $row['unit_cost'], 2);
                $lineTotal = round($unitCost * $quantity, 2);
                $batchNumber = !empty($row['batch_number']) ? trim((string) $row['batch_number']) : null;
                $manufacturingDate = !empty($row['manufacturing_date']) ? (string) $row['manufacturing_date'] : null;
                $expiryDate = !empty($row['expiry_date']) ? (string) $row['expiry_date'] : null;

                if ($manufacturingDate && $expiryDate && strtotime($expiryDate) < strtotime($manufacturingDate)) {
                    throw new \RuntimeException('Expiry date must be greater than or equal to manufacturing date.');
                }

                StockReceiptItem::create([
                    'receipt_id' => $receipt->id,
                    'product_id' => $productId,
                    'batch_number' => $batchNumber,
                    'manufacturing_date' => $manufacturingDate,
                    'expiry_date' => $expiryDate,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'line_total' => $lineTotal,
                ]);

                $inventory = Inventory::query()
                    ->where('product_id', $productId)
                    ->where('warehouse_id', $data['warehouse_id'])
                    ->when($batchNumber !== null, function ($query) use ($batchNumber) {
                        $query->where('batch_number', $batchNumber);
                    }, function ($query) use ($data) {
                        $query->whereNull('batch_number')
                            ->where('supplier_id', $data['supplier_id']);
                    })
                    ->lockForUpdate()
                    ->first();

                if ($inventory) {
                    $inventory->quantity = (int) $inventory->quantity + $quantity;
                    $inventory->unit_cost = $unitCost;
                    if ($batchNumber !== null) {
                        $inventory->batch_number = $batchNumber;
                    }
                    if ($manufacturingDate) {
                        $inventory->manufacturing_date = $manufacturingDate;
                    }
                    if ($expiryDate) {
                        $inventory->expiry_date = $expiryDate;
                    }
                    $inventory->save();
                } else {
                    $inventory = Inventory::create([
                        'product_id' => $productId,
                        'warehouse_id' => $data['warehouse_id'],
                        'supplier_id' => $data['supplier_id'],
                        'quantity' => $quantity,
                        'unit_cost' => $unitCost,
                        'batch_number' => $batchNumber,
                        'manufacturing_date' => $manufacturingDate,
                        'expiry_date' => $expiryDate,
                    ]);
                }

                Transaction::create([
                    'transaction_number' => 'TRX-REC-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                    'product_id' => $productId,
                    'inventory_id' => $inventory->id,
                    'transaction_type' => 'in',
                    'quantity' => $quantity,
                    'unit_price' => $unitCost,
                    'total_amount' => $lineTotal,
                    'warehouse_id' => $data['warehouse_id'],
                    'user_id' => $request->user()->id,
                    'supplier_id' => $data['supplier_id'],
                    'reference_number' => $referenceNo,
                    'notes' => 'Supply delivery received'
                        . ($batchNumber ? " | Batch: {$batchNumber}" : '')
                        . ($expiryDate ? " | Expiry: {$expiryDate}" : ''),
                ]);

                $newTotalStock = (int) Inventory::query()
                    ->where('product_id', $productId)
                    ->sum('quantity');
                Product::where('id', $productId)->update(['current_stock' => $newTotalStock]);
            }

            return $receipt;
        });

        AuditLogger::log($request, 'stock_receipt_created', 'stock_receipt', $receipt->id, [
            'reference_no' => $receipt->reference_no,
            'supplier_id' => $receipt->supplier_id,
            'warehouse_id' => $data['warehouse_id'],
        ]);

        return response()->json([
            'message' => 'Supply delivery recorded successfully.',
            'receipt' => $receipt->load(['supplier:id,name', 'receivedBy:id,name', 'items.product:id,name,sku']),
        ], 201);
    }
}
