<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class SmartFeatureController extends Controller
{
    public function forecastDemand(Request $request)
    {
        $data = $request->validate([
            'lookback_days' => 'nullable|integer|min:7|max:365',
            'forecast_days' => 'nullable|integer|min:7|max:180',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'limit' => 'nullable|integer|min:1|max:200',
        ]);

        $lookbackDays = (int) ($data['lookback_days'] ?? 60);
        $forecastDays = (int) ($data['forecast_days'] ?? 30);
        $branchId = isset($data['branch_id']) ? (int) $data['branch_id'] : null;
        $limit = (int) ($data['limit'] ?? 40);

        $demandQuery = Transaction::query()
            ->where('transaction_type', 'out')
            ->where('created_at', '>=', now()->subDays($lookbackDays));

        if ($branchId) {
            $demandQuery->join('warehouses', 'transactions.warehouse_id', '=', 'warehouses.id')
                ->where('warehouses.branch_id', $branchId);
        }

        $demandMap = $demandQuery
            ->selectRaw('transactions.product_id, COALESCE(SUM(transactions.quantity), 0) as moved_qty')
            ->groupBy('transactions.product_id')
            ->pluck('moved_qty', 'transactions.product_id');

        $branchStockMap = collect();
        if ($branchId) {
            $branchStockMap = Inventory::query()
                ->join('warehouses', 'inventory.warehouse_id', '=', 'warehouses.id')
                ->where('warehouses.branch_id', $branchId)
                ->selectRaw('inventory.product_id, COALESCE(SUM(inventory.quantity), 0) as stock')
                ->groupBy('inventory.product_id')
                ->pluck('stock', 'inventory.product_id');
        }

        $products = Product::query()
            ->with('category:id,name')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $items = $products->map(function (Product $product) use ($demandMap, $branchStockMap, $lookbackDays, $forecastDays, $branchId) {
            $historicDemand = (float) ($demandMap[$product->id] ?? 0);
            $averageDailyDemand = $historicDemand > 0 ? ($historicDemand / max($lookbackDays, 1)) : 0.0;
            $predictedDemand = round($averageDailyDemand * $forecastDays, 2);

            $currentStock = $branchId
                ? (int) ($branchStockMap[$product->id] ?? 0)
                : (int) $product->current_stock;

            $safetyStock = max((int) $product->reorder_point, (int) $product->min_stock_level);
            $suggestedRestock = (int) max(ceil(($predictedDemand + $safetyStock) - $currentStock), 0);

            return [
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'category' => $product->category?->name,
                'current_stock' => $currentStock,
                'reorder_point' => (int) $product->reorder_point,
                'historic_demand_qty' => round($historicDemand, 2),
                'average_daily_demand' => round($averageDailyDemand, 3),
                'predicted_demand_qty' => $predictedDemand,
                'suggested_restock_qty' => $suggestedRestock,
            ];
        })->sortByDesc(function (array $row) {
            return ($row['suggested_restock_qty'] * 1000) + $row['predicted_demand_qty'];
        })->take($limit)->values();

        return response()->json([
            'lookback_days' => $lookbackDays,
            'forecast_days' => $forecastDays,
            'branch_id' => $branchId,
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function seasonalSuggestions(Request $request)
    {
        $data = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $month = (int) ($data['month'] ?? now()->month);
        $branchId = isset($data['branch_id']) ? (int) $data['branch_id'] : null;
        $limit = (int) ($data['limit'] ?? 20);

        $isWetSeason = in_array($month, [6, 7, 8, 9, 10, 11], true);
        $season = $isWetSeason ? 'wet_season' : 'dry_season';
        $keywords = $isWetSeason
            ? ['fungicide', 'pesticide', 'flood', 'rain', 'drainage', 'wet', 'disease']
            : ['irrigation', 'mulch', 'drought', 'heat', 'summer', 'dry', 'sprinkler'];

        $recentDemandQuery = Transaction::query()
            ->where('transaction_type', 'out')
            ->where('created_at', '>=', now()->subDays(120));

        if ($branchId) {
            $recentDemandQuery->join('warehouses', 'transactions.warehouse_id', '=', 'warehouses.id')
                ->where('warehouses.branch_id', $branchId);
        }

        $recentDemandMap = $recentDemandQuery
            ->selectRaw('transactions.product_id, COALESCE(SUM(transactions.quantity), 0) as moved_qty')
            ->groupBy('transactions.product_id')
            ->pluck('moved_qty', 'transactions.product_id');

        $branchStockMap = collect();
        if ($branchId) {
            $branchStockMap = Inventory::query()
                ->join('warehouses', 'inventory.warehouse_id', '=', 'warehouses.id')
                ->where('warehouses.branch_id', $branchId)
                ->selectRaw('inventory.product_id, COALESCE(SUM(inventory.quantity), 0) as stock')
                ->groupBy('inventory.product_id')
                ->pluck('stock', 'inventory.product_id');
        }

        $items = Product::query()
            ->with('category:id,name')
            ->where('is_active', true)
            ->get()
            ->map(function (Product $product) use ($keywords, $recentDemandMap, $branchStockMap, $branchId) {
                $text = strtolower(trim(implode(' ', [
                    $product->name ?? '',
                    $product->description ?? '',
                    $product->category?->name ?? '',
                ])));

                $matchedKeywords = [];
                foreach ($keywords as $keyword) {
                    if (str_contains($text, $keyword)) {
                        $matchedKeywords[] = $keyword;
                    }
                }

                $keywordScore = count($matchedKeywords) * 2;
                $recentDemandQty = (float) ($recentDemandMap[$product->id] ?? 0);
                $demandScore = min($recentDemandQty / 10, 6);
                $stock = $branchId
                    ? (int) ($branchStockMap[$product->id] ?? 0)
                    : (int) $product->current_stock;
                $availabilityScore = $stock > 0 ? 1 : 0;

                $totalScore = round($keywordScore + $demandScore + $availabilityScore, 2);

                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category?->name,
                    'stock' => $stock,
                    'recent_demand_qty' => round($recentDemandQty, 2),
                    'score' => $totalScore,
                    'matched_keywords' => $matchedKeywords,
                ];
            })
            ->filter(fn (array $row) => $row['score'] > 0 && $row['stock'] > 0)
            ->sortByDesc('score')
            ->take($limit)
            ->values();

        return response()->json([
            'month' => $month,
            'season' => $season,
            'branch_id' => $branchId,
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function branchInventoryOverview(Request $request)
    {
        $data = $request->validate([
            'include_inactive' => 'nullable|boolean',
        ]);

        $includeInactive = (bool) ($data['include_inactive'] ?? false);
        $branchQuery = Branch::query()->orderBy('name');
        if (!$includeInactive) {
            $branchQuery->where('is_active', true);
        }

        $branches = $branchQuery->get(['id', 'name', 'code', 'location', 'is_active']);
        $branchIds = $branches->pluck('id')->all();

        $stockMetrics = collect();
        if (!empty($branchIds)) {
            $stockMetrics = Inventory::query()
                ->join('warehouses', 'inventory.warehouse_id', '=', 'warehouses.id')
                ->whereIn('warehouses.branch_id', $branchIds)
                ->selectRaw('warehouses.branch_id as branch_id, COUNT(DISTINCT inventory.product_id) as products_count, COALESCE(SUM(inventory.quantity), 0) as total_units, COALESCE(SUM(inventory.quantity * inventory.unit_cost), 0) as inventory_value')
                ->groupBy('warehouses.branch_id')
                ->get()
                ->keyBy('branch_id');
        }

        $warehouseCounts = Warehouse::query()
            ->whereIn('branch_id', $branchIds)
            ->selectRaw('branch_id, COUNT(*) as total')
            ->groupBy('branch_id')
            ->pluck('total', 'branch_id');

        $items = $branches->map(function (Branch $branch) use ($stockMetrics, $warehouseCounts) {
            $metric = $stockMetrics->get($branch->id);
            return [
                'branch_id' => $branch->id,
                'name' => $branch->name,
                'code' => $branch->code,
                'location' => $branch->location,
                'is_active' => (bool) $branch->is_active,
                'warehouses_count' => (int) ($warehouseCounts[$branch->id] ?? 0),
                'products_count' => (int) ($metric->products_count ?? 0),
                'total_units' => (int) ($metric->total_units ?? 0),
                'inventory_value' => round((float) ($metric->inventory_value ?? 0), 2),
            ];
        })->values();

        $unassignedWarehouses = Warehouse::query()
            ->whereNull('branch_id')
            ->orderBy('name')
            ->get(['id', 'name', 'code', 'location', 'is_active']);

        return response()->json([
            'count' => $items->count(),
            'items' => $items,
            'unassigned_warehouses_count' => $unassignedWarehouses->count(),
            'unassigned_warehouses' => $unassignedWarehouses,
        ]);
    }
}
