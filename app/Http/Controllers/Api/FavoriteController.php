<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $items = $request->user()
            ->favoriteProducts()
            ->with(['category:id,name', 'supplier:id,name'])
            ->orderBy('products.name')
            ->get();

        return response()->json([
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $request->user()->favoriteProducts()->syncWithoutDetaching([$product->id]);

        return response()->json([
            'message' => 'Product added to favorites.',
            'product_id' => $product->id,
        ], 201);
    }

    public function destroy(Request $request, Product $product)
    {
        $request->user()->favoriteProducts()->detach($product->id);

        return response()->json([
            'message' => 'Product removed from favorites.',
            'product_id' => $product->id,
        ]);
    }

    public function lowStockAlerts(Request $request)
    {
        $items = $request->user()
            ->favoriteProducts()
            ->whereRaw('products.current_stock <= products.reorder_point')
            ->orderBy('products.current_stock')
            ->get(['products.id', 'products.name', 'products.sku', 'products.current_stock', 'products.reorder_point', 'products.unit_price']);

        return response()->json([
            'count' => $items->count(),
            'items' => $items,
        ]);
    }
}

