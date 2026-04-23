<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\User;
use App\Models\UserNotification;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'active_only' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Promotion::query()
            ->with(['createdBy:id,name'])
            ->latest();

        $activeOnly = $data['active_only'] ?? true;
        if ($activeOnly) {
            $query->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                });
        }

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'code' => 'nullable|string|max:100|unique:promotions,code',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $promotion = Promotion::create([
            ...$data,
            'is_active' => $data['is_active'] ?? true,
            'created_by_user_id' => $request->user()->id,
        ]);

        if ($promotion->is_active) {
            $customerIds = User::query()->where('role', 'customer')->pluck('id');
            foreach ($customerIds as $customerId) {
                UserNotification::create([
                    'user_id' => $customerId,
                    'type' => 'promotion',
                    'title' => 'New promotion available',
                    'message' => $promotion->title,
                    'data' => [
                        'promotion_id' => $promotion->id,
                        'code' => $promotion->code,
                    ],
                ]);
            }
        }

        AuditLogger::log($request, 'promotion_created', 'promotion', $promotion->id, [
            'title' => $promotion->title,
            'code' => $promotion->code,
        ]);

        return response()->json([
            'message' => 'Promotion created successfully.',
            'promotion' => $promotion->load(['createdBy:id,name']),
        ], 201);
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'code' => 'nullable|string|max:100|unique:promotions,code,' . $promotion->id,
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
        ]);

        $promotion->update($data);

        AuditLogger::log($request, 'promotion_updated', 'promotion', $promotion->id, [
            'title' => $promotion->title,
            'code' => $promotion->code,
            'is_active' => $promotion->is_active,
        ]);

        return response()->json([
            'message' => 'Promotion updated successfully.',
            'promotion' => $promotion->fresh(['createdBy:id,name']),
        ]);
    }

    public function destroy(Request $request, Promotion $promotion)
    {
        $promotionId = $promotion->id;
        $promotionTitle = $promotion->title;
        $promotion->delete();

        AuditLogger::log($request, 'promotion_deleted', 'promotion', $promotionId, [
            'title' => $promotionTitle,
        ]);

        return response()->json([
            'message' => 'Promotion deleted successfully.',
        ]);
    }
}
