<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function productReviews(Request $request, Product $product)
    {
        $data = $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = $data['per_page'] ?? 20;

        $reviews = ProductReview::query()
            ->with(['user:id,name'])
            ->where('product_id', $product->id)
            ->where('is_approved', true)
            ->latest()
            ->paginate($perPage)
            ->appends($request->query());

        $averageRating = (float) ProductReview::query()
            ->where('product_id', $product->id)
            ->where('is_approved', true)
            ->avg('rating');

        return response()->json([
            'product_id' => $product->id,
            'average_rating' => round($averageRating, 2),
            'reviews' => $reviews,
        ]);
    }

    public function myReviews(Request $request)
    {
        $data = $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            ProductReview::query()
                ->with(['product:id,name,sku,unit_price'])
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate($perPage)
                ->appends($request->query())
        );
    }

    public function storeOrUpdate(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ]);

        $review = ProductReview::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $data['product_id'],
            ],
            [
                'rating' => $data['rating'],
                'review' => $data['review'] ?? null,
                'is_approved' => true,
            ]
        );

        return response()->json([
            'message' => 'Product review saved successfully.',
            'review' => $review->load(['product:id,name,sku', 'user:id,name']),
        ], 201);
    }
}

