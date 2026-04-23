<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Transaction;
use App\Models\UserNotification;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function customerIndex(Request $request)
    {
        $data = $request->validate([
            'status' => 'nullable|in:pending,processing,completed,cancelled',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Order::query()
            ->with(['items.product:id,name,sku,unit_price', 'processedBy:id,name'])
            ->where('customer_user_id', $request->user()->id)
            ->latest('placed_at');

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function customerShow(Request $request, Order $order)
    {
        if ((int) $order->customer_user_id !== (int) $request->user()->id) {
            return response()->json(['message' => 'You can only view your own orders'], 403);
        }

        return response()->json(
            $order->load(['items.product:id,name,sku,unit_price,description,current_stock', 'processedBy:id,name'])
        );
    }

    public function customerStore(Request $request)
    {
        $data = $request->validate([
            'payment_method' => 'required|in:cash,online_payment,cod',
            'promotion_code' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1|max:100',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:1000000',
        ]);

        $order = DB::transaction(function () use ($data, $request) {
            $grouped = [];
            foreach ($data['items'] as $item) {
                $productId = (int) $item['product_id'];
                $quantity = (int) $item['quantity'];
                $grouped[$productId] = ($grouped[$productId] ?? 0) + $quantity;
            }

            $subtotal = 0.0;
            $orderLines = [];

            foreach ($grouped as $productId => $quantity) {
                $product = Product::findOrFail($productId);
                if ($product->current_stock < $quantity) {
                    throw new \RuntimeException("Insufficient stock for {$product->name}.");
                }

                $unitPrice = (float) $product->unit_price;
                $lineTotal = round($unitPrice * $quantity, 2);
                $subtotal += $lineTotal;

                $orderLines[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ];
            }

            $subtotal = round($subtotal, 2);
            $discount = 0.0;
            $promotionUsed = null;

            if (!empty($data['promotion_code'])) {
                $promotion = Promotion::query()
                    ->where('code', $data['promotion_code'])
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                    })
                    ->first();

                if (!$promotion) {
                    throw new \RuntimeException('Promotion code is invalid or inactive.');
                }

                $promotionUsed = $promotion;
                $discount = $promotion->discount_type === 'fixed'
                    ? (float) $promotion->discount_value
                    : ($subtotal * ((float) $promotion->discount_value / 100));
            }

            $discount = min(max(round($discount, 2), 0), $subtotal);
            $total = round($subtotal - $discount, 2);

            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                'customer_user_id' => $request->user()->id,
                'status' => 'pending',
                'payment_method' => $data['payment_method'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'notes' => $data['notes'] ?? null,
                'placed_at' => now(),
            ]);

            foreach ($orderLines as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $line['product_id'],
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'line_total' => $line['line_total'],
                ]);
            }

            UserNotification::create([
                'user_id' => $request->user()->id,
                'type' => 'order_update',
                'title' => 'Order placed successfully',
                'message' => 'Your order ' . $order->order_number . ' is now pending.',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'promotion_code' => $promotionUsed?->code,
                ],
            ]);

            AuditLogger::log(
                $request,
                'order_created',
                'order',
                $order->id,
                [
                    'order_number' => $order->order_number,
                    'payment_method' => $order->payment_method,
                    'total' => (float) $order->total,
                ]
            );

            return $order;
        });

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order->load(['items.product:id,name,sku,unit_price']),
        ], 201);
    }

    public function adminIndex(Request $request)
    {
        $data = $request->validate([
            'status' => 'nullable|in:pending,processing,completed,cancelled',
            'search' => 'nullable|string|max:255',
            'per_page' => 'nullable|integer|min:1|max:200',
        ]);

        $query = Order::query()
            ->with(['customer:id,name,email', 'processedBy:id,name', 'items.product:id,name,sku'])
            ->latest('placed_at');

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $perPage = $data['per_page'] ?? 30;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function adminShow(Order $order)
    {
        return response()->json(
            $order->load(['customer:id,name,email', 'processedBy:id,name', 'items.product:id,name,sku,unit_price,current_stock'])
        );
    }

    public function adminUpdateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($order->status === 'completed' && $data['status'] !== 'completed') {
            return response()->json([
                'message' => 'Completed orders cannot be reverted.',
            ], 422);
        }

        if ($order->status === $data['status']) {
            return response()->json([
                'message' => 'Order status is already ' . $data['status'] . '.',
                'order' => $order->load(['customer:id,name,email', 'items.product:id,name,sku']),
            ]);
        }

        try {
            DB::transaction(function () use ($request, $order, $data) {
                $order->load('items.product');

                if ($data['status'] === 'completed' && $order->status !== 'completed') {
                    foreach ($order->items as $item) {
                        $requiredQty = (int) $item->quantity;

                        $inventories = Inventory::query()
                            ->where('product_id', $item->product_id)
                            ->where('quantity', '>', 0)
                            ->orderByDesc('quantity')
                            ->lockForUpdate()
                            ->get();

                        $available = (int) $inventories->sum('quantity');
                        if ($available < $requiredQty) {
                            throw new \RuntimeException("Insufficient stock to complete order for {$item->product?->name}.");
                        }

                        $remaining = $requiredQty;
                        foreach ($inventories as $inventory) {
                            if ($remaining <= 0) {
                                break;
                            }

                            $deductQty = min($remaining, (int) $inventory->quantity);
                            if ($deductQty <= 0) {
                                continue;
                            }

                            $inventory->quantity = (int) $inventory->quantity - $deductQty;
                            $inventory->save();

                            Transaction::create([
                                'transaction_number' => 'TRX-ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                                'product_id' => $item->product_id,
                                'inventory_id' => $inventory->id,
                                'transaction_type' => 'out',
                                'quantity' => $deductQty,
                                'unit_price' => (float) $item->unit_price,
                                'total_amount' => round(((float) $item->unit_price) * $deductQty, 2),
                                'warehouse_id' => $inventory->warehouse_id,
                                'user_id' => $request->user()->id,
                                'supplier_id' => $inventory->supplier_id,
                                'reference_number' => $order->order_number,
                                'notes' => 'Order completed: ' . $order->order_number,
                            ]);

                            $remaining -= $deductQty;
                        }

                        $productTotal = (int) Inventory::query()
                            ->where('product_id', $item->product_id)
                            ->sum('quantity');
                        Product::where('id', $item->product_id)->update(['current_stock' => $productTotal]);
                    }
                }

                if (!empty($data['notes'])) {
                    $order->notes = $order->notes
                        ? ($order->notes . ' | ' . $data['notes'])
                        : $data['notes'];
                }

                $order->status = $data['status'];
                $order->processed_by_user_id = $request->user()->id;
                $order->processed_at = now();
                $order->save();

                UserNotification::create([
                    'user_id' => $order->customer_user_id,
                    'type' => 'order_update',
                    'title' => 'Order status updated',
                    'message' => 'Your order ' . $order->order_number . ' is now ' . $order->status . '.',
                    'data' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                    ],
                ]);

                AuditLogger::log(
                    $request,
                    'order_status_updated',
                    'order',
                    $order->id,
                    [
                        'order_number' => $order->order_number,
                        'new_status' => $order->status,
                    ]
                );
            });
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order->fresh(['customer:id,name,email', 'processedBy:id,name', 'items.product:id,name,sku,unit_price,current_stock']),
        ]);
    }
}

