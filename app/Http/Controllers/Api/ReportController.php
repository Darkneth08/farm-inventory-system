<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function lowStock()
    {
        $products = Product::with(['category', 'supplier'])
            ->whereRaw('current_stock <= reorder_point')
            ->orderByRaw('(reorder_point - current_stock) DESC')
            ->get();

        return response()->json([
            'count' => $products->count(),
            'items' => $products,
        ]);
    }

    public function sales(Request $request)
    {
        $from = $request->filled('from')
            ? now()->parse($request->input('from'))
            : now()->startOfMonth();
        $to = $request->filled('to')
            ? now()->parse($request->input('to'))
            : now()->endOfMonth();

        $transactions = Transaction::with('product')
            ->where('transaction_type', 'out')
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->orderBy('created_at')
            ->get();

        $summary = [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'total_transactions' => $transactions->count(),
            'total_quantity' => (int) $transactions->sum('quantity'),
            'total_sales' => (float) $transactions->sum('total_amount'),
        ];

        $daily = Transaction::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->where('transaction_type', 'out')
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return response()->json([
            'summary' => $summary,
            'daily_sales' => $daily,
            'transactions' => $transactions,
        ]);
    }

    public function inventoryValue()
    {
        $byWarehouse = Inventory::query()
            ->join('warehouses', 'inventory.warehouse_id', '=', 'warehouses.id')
            ->selectRaw('warehouses.id, warehouses.name, SUM(inventory.quantity * inventory.unit_cost) as value')
            ->groupBy('warehouses.id', 'warehouses.name')
            ->orderByDesc('value')
            ->get();

        $total = (float) $byWarehouse->sum('value');

        return response()->json([
            'total_value' => $total,
            'by_warehouse' => $byWarehouse,
        ]);
    }

    public function expiringStock(Request $request)
    {
        $withinDays = (int) $request->input('days', 45);
        $cutoff = now()->addDays(max(1, $withinDays))->toDateString();

        $items = Inventory::with(['product', 'warehouse', 'supplier'])
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<=', $cutoff)
            ->orderBy('expiry_date')
            ->get();

        return response()->json([
            'within_days' => $withinDays,
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function movementSummary(Request $request)
    {
        $from = $request->filled('from')
            ? now()->parse($request->input('from'))
            : now()->startOfMonth();
        $to = $request->filled('to')
            ? now()->parse($request->input('to'))
            : now()->endOfMonth();

        $summary = Transaction::query()
            ->selectRaw('transaction_type, SUM(quantity) as total_qty, SUM(total_amount) as total_amount')
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->groupBy('transaction_type')
            ->orderBy('transaction_type')
            ->get();

        return response()->json([
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'summary' => $summary,
        ]);
    }

    public function businessOverview(Request $request)
    {
        $data = $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $from = isset($data['from'])
            ? now()->parse($data['from'])->startOfDay()
            : now()->startOfMonth()->startOfDay();
        $to = isset($data['to'])
            ? now()->parse($data['to'])->endOfDay()
            : now()->endOfDay();
        $limit = (int) ($data['limit'] ?? 10);

        if ($to->lt($from)) {
            return response()->json([
                'message' => 'The "to" date must be greater than or equal to the "from" date.',
            ], 422);
        }

        $hasSalesTable = Schema::hasTable('sales') && Schema::hasTable('sale_items');
        if ($hasSalesTable) {
            $dailySales = Sale::query()
                ->selectRaw('DATE(sold_at) as date, COUNT(*) as orders, COALESCE(SUM(total), 0) as revenue')
                ->whereBetween('sold_at', [$from, $to])
                ->groupBy(DB::raw('DATE(sold_at)'))
                ->orderBy('date')
                ->get();

            $topSellingProducts = SaleItem::query()
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->selectRaw('products.id as product_id, products.name as product_name, SUM(sale_items.quantity) as quantity_sold, COALESCE(SUM(sale_items.line_total), 0) as revenue')
                ->whereBetween('sales.sold_at', [$from, $to])
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('quantity_sold')
                ->limit($limit)
                ->get();
        } else {
            $dailySales = Transaction::query()
                ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, COALESCE(SUM(total_amount), 0) as revenue')
                ->where('transaction_type', 'out')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            $topSellingProducts = Transaction::query()
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->selectRaw('products.id as product_id, products.name as product_name, SUM(transactions.quantity) as quantity_sold, COALESCE(SUM(transactions.total_amount), 0) as revenue')
                ->where('transactions.transaction_type', 'out')
                ->whereBetween('transactions.created_at', [$from, $to])
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('quantity_sold')
                ->limit($limit)
                ->get();
        }

        $inventoryValue = (float) Inventory::query()
            ->selectRaw('COALESCE(SUM(quantity * unit_cost), 0) as total')
            ->value('total');

        $lowStock = Product::query()
            ->whereRaw('current_stock <= reorder_point')
            ->orderByRaw('(reorder_point - current_stock) DESC')
            ->limit($limit)
            ->get(['id', 'name', 'sku', 'current_stock', 'reorder_point']);

        $ordersTotal = 0;
        if (Schema::hasTable('orders')) {
            $ordersTotal = (int) Order::query()
                ->whereBetween('created_at', [$from, $to])
                ->count();
        } else {
            $ordersTotal = (int) $dailySales->sum('orders');
        }

        return response()->json([
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'totals' => [
                'orders' => $ordersTotal,
                'revenue' => (float) $dailySales->sum('revenue'),
                'inventory_value' => $inventoryValue,
            ],
            'daily_sales' => $dailySales,
            'top_selling_products' => $topSellingProducts,
            'low_stock_report' => $lowStock,
            'inventory_status' => [
                'in_stock' => Product::query()->whereRaw('current_stock > reorder_point')->count(),
                'low_stock' => Product::query()->whereRaw('current_stock <= reorder_point AND current_stock > 0')->count(),
                'out_of_stock' => Product::query()->where('current_stock', '<=', 0)->count(),
            ],
        ]);
    }
}
