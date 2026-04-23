<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'stock_status' => 'nullable|in:low,out,in',
            'is_active' => 'nullable|boolean',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort_by' => 'nullable|in:name,unit_price,current_stock,created_at',
            'sort_dir' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Product::with(['category', 'supplier']);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('sku', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('barcode', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['stock_status'])) {
            switch ($filters['stock_status']) {
                case 'low':
                    $query->whereRaw('current_stock <= reorder_point');
                    break;
                case 'out':
                    $query->where('current_stock', '<=', 0);
                    break;
                case 'in':
                    $query->where('current_stock', '>', 0);
                    break;
            }
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if (array_key_exists('min_price', $filters)) {
            $query->where('unit_price', '>=', $filters['min_price']);
        }

        if (array_key_exists('max_price', $filters)) {
            $query->where('unit_price', '<=', $filters['max_price']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? ($sortBy === 'name' ? 'asc' : 'desc');
        $perPage = $filters['per_page'] ?? 15;

        $products = $query
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json([
            'products' => $products,
            'filters' => $request->only([
                'search',
                'category_id',
                'stock_status',
                'is_active',
                'min_price',
                'max_price',
                'sort_by',
                'sort_dir',
                'per_page',
            ]),
        ]);
    }

    public function summary()
    {
        $estimatedRetailValue = Product::query()
            ->selectRaw('COALESCE(SUM(current_stock * unit_price), 0) as total')
            ->value('total');

        return response()->json([
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'inactive_products' => Product::where('is_active', false)->count(),
            'low_stock_products' => Product::whereRaw('current_stock <= reorder_point')->count(),
            'out_of_stock_products' => Product::where('current_stock', '<=', 0)->count(),
            'total_stock_units' => (int) Product::sum('current_stock'),
            'estimated_retail_value' => (float) $estimatedRetailValue,
        ]);
    }

    public function reorderSuggestions(Request $request)
    {
        $data = $request->validate([
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $limit = $data['limit'] ?? 25;

        $items = Product::with('category')
            ->whereRaw('current_stock <= reorder_point')
            ->orderByRaw('(reorder_point - current_stock) DESC')
            ->limit($limit)
            ->get()
            ->map(function (Product $product) {
                $targetLevel = $product->max_stock_level ?? max($product->reorder_point, $product->min_stock_level + 1);

                if ($targetLevel <= $product->current_stock) {
                    $targetLevel = $product->reorder_point + max(1, (int) ceil(max($product->reorder_point, 1) * 0.2));
                }

                $recommendedQty = max($targetLevel - $product->current_stock, 1);

                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category?->name,
                    'current_stock' => (int) $product->current_stock,
                    'reorder_point' => (int) $product->reorder_point,
                    'max_stock_level' => $product->max_stock_level,
                    'recommended_order_qty' => $recommendedQty,
                ];
            })
            ->values();

        return response()->json([
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function toggleActive(Request $request, Product $product)
    {
        $data = $request->validate([
            'is_active' => 'nullable|boolean',
        ]);

        $nextStatus = array_key_exists('is_active', $data)
            ? (bool) $data['is_active']
            : !$product->is_active;

        $product->is_active = $nextStatus;
        $product->save();

        return response()->json([
            'message' => 'Product status updated successfully',
            'product' => $product->fresh(['category', 'supplier']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'unit_price' => 'required|numeric|min:0',
            'unit_of_measure' => 'required|string',
            'min_stock_level' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('product-images', 'public');
        }

        $product = Product::create([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'barcode' => $request->barcode,
            'description' => $request->description,
            'category_id' => $data['category_id'],
            'supplier_id' => $data['supplier_id'] ?? null,
            'unit_price' => $data['unit_price'],
            'unit_of_measure' => $data['unit_of_measure'],
            'min_stock_level' => $data['min_stock_level'],
            'max_stock_level' => $request->max_stock_level,
            'reorder_point' => $data['reorder_point'],
            'image' => $imagePath ?? $request->image,
            'is_active' => true
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product->load(['category', 'supplier'])
        ], 201);
    }

    public function show(Product $product)
    {
        return response()->json(
            $product->load(['category', 'supplier', 'inventory.warehouse'])
        );
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'unit_price' => 'required|numeric|min:0',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $payload = $request->only([
            'name',
            'sku',
            'barcode',
            'description',
            'category_id',
            'supplier_id',
            'unit_price',
            'unit_of_measure',
            'min_stock_level',
            'max_stock_level',
            'reorder_point',
            'image',
            'is_active',
        ]);

        if ($request->hasFile('image_file')) {
            if (!empty($product->image) && !str_starts_with((string) $product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $payload['image'] = $request->file('image_file')->store('product-images', 'public');
        }

        $product->update(array_merge($payload, [
            'name' => $data['name'],
            'sku' => $data['sku'],
            'category_id' => $data['category_id'],
            'supplier_id' => $data['supplier_id'] ?? null,
            'unit_price' => $data['unit_price'],
        ]));

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->fresh(['category', 'supplier'])
        ]);
    }

    public function destroy(Product $product)
    {
        // Check if product has inventory
        if ($product->inventory()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete product with existing inventory'
            ], 400);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function stockHistory(Product $product)
    {
        $history = $product->transactions()
            ->with(['user', 'warehouse'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($history);
    }
}
