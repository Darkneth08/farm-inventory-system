<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'role' => $user->role,
            'status' => $user->status,
            'created_at' => $user->created_at,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->only(['id', 'name', 'email', 'phone', 'address', 'role', 'status']),
        ]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $user->password = Hash::make($data['password']);
        $user->save();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Password changed successfully. Please log in again.',
        ]);
    }

    public function requests(Request $request)
    {
        $data = $request->validate([
            'status' => 'nullable|in:pending,processing,fulfilled,cancelled',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = CustomerRequest::query()
            ->with(['product:id,name,sku,unit_price,unit_of_measure,current_stock,reorder_point'])
            ->where('user_id', $request->user()->id)
            ->latest();

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function storeRequest(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'requested_quantity' => 'required|integer|min:1|max:1000000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $customerRequest = CustomerRequest::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'requested_quantity' => $data['requested_quantity'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Customer request submitted successfully',
            'request' => $customerRequest->load([
                'product:id,name,sku,unit_price,unit_of_measure,current_stock,reorder_point',
            ]),
        ], 201);
    }

    public function cancelRequest(Request $request, CustomerRequest $customerRequest)
    {
        if ((int) $customerRequest->user_id !== (int) $request->user()->id) {
            return response()->json([
                'message' => 'You can only cancel your own requests',
            ], 403);
        }

        if ($customerRequest->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending requests can be cancelled',
            ], 422);
        }

        $customerRequest->status = 'cancelled';
        $customerRequest->processed_at = now();
        $customerRequest->save();

        return response()->json([
            'message' => 'Customer request cancelled successfully',
            'request' => $customerRequest->fresh([
                'product:id,name,sku,unit_price,unit_of_measure,current_stock,reorder_point',
            ]),
        ]);
    }
}
