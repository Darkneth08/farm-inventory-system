<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $lowStockProducts = Product::whereRaw('current_stock <= reorder_point')->count();
        $outOfStockProducts = Product::where('current_stock', '<=', 0)->count();

        $inventoryValue = Inventory::select(DB::raw('COALESCE(SUM(quantity * unit_cost), 0) as total'))->value('total');
        $availableInventoryUnits = (int) Inventory::sum('quantity');
        $todaySales = Transaction::where('transaction_type', 'out')
            ->whereDate('created_at', today())
            ->sum('total_amount');
        $monthSales = Transaction::where('transaction_type', 'out')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_amount');

        $totalOrders = 0;
        $pendingOrders = 0;
        $completedOrders = 0;
        if (Schema::hasTable('orders')) {
            $totalOrders = Order::count();
            $pendingOrders = Order::where('status', 'pending')->count();
            $completedOrders = Order::where('status', 'completed')->count();
        }

        $recentTransactions = Transaction::with(['product', 'warehouse', 'user'])
            ->latest()
            ->take(8)
            ->get();

        $stockByCategory = Product::query()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(products.current_stock) as stock')
            ->groupBy('categories.name')
            ->orderByDesc('stock')
            ->get();

        $monthlySalesTrend = Transaction::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as total")
            ->where('transaction_type', 'out')
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month')
            ->get();

        $topProducts = Transaction::query()
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(transactions.quantity) as moved_qty')
            ->whereIn('transactions.transaction_type', ['out', 'transfer'])
            ->groupBy('products.name')
            ->orderByDesc('moved_qty')
            ->limit(5)
            ->get();

        $overview = [
            'categories' => Category::count(),
            'suppliers' => Supplier::count(),
            'branches' => class_exists(Branch::class) ? Branch::count() : 0,
            'warehouses' => Warehouse::count(),
            'users' => User::count(),
        ];

        return response()->json([
            'kpis' => [
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
                'low_stock_products' => $lowStockProducts,
                'out_of_stock_products' => $outOfStockProducts,
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'completed_orders' => $completedOrders,
                'inventory_value' => (float) $inventoryValue,
                'available_inventory_units' => $availableInventoryUnits,
                'today_sales' => (float) $todaySales,
                'month_sales' => (float) $monthSales,
            ],
            'overview' => $overview,
            'stock_by_category' => $stockByCategory,
            'monthly_sales_trend' => $monthlySalesTrend,
            'top_products' => $topProducts,
            'recent_transactions' => $recentTransactions,
        ]);
    }
}
