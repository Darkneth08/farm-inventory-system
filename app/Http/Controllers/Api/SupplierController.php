<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('contact_person', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json($query->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $supplier = Supplier::create($data + ['is_active' => $data['is_active'] ?? true]);

        return response()->json([
            'message' => 'Supplier created successfully',
            'supplier' => $supplier,
        ], 201);
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier->loadCount(['products', 'inventory', 'transactions']));
    }

    public function performance(Request $request)
    {
        $data = $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'limit' => 'nullable|integer|min:1|max:100',
            'is_active' => 'nullable|boolean',
        ]);

        $from = isset($data['from']) ? now()->parse($data['from'])->startOfDay() : now()->startOfMonth()->startOfDay();
        $to = isset($data['to']) ? now()->parse($data['to'])->endOfDay() : now()->endOfMonth()->endOfDay();
        $limit = $data['limit'] ?? 20;

        if ($to->lt($from)) {
            return response()->json([
                'message' => 'The "to" date must be greater than or equal to the "from" date.',
            ], 422);
        }

        $query = Supplier::query()
            ->select(['id', 'name', 'contact_person', 'email', 'phone', 'is_active'])
            ->withCount([
                'transactions as transaction_count' => function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);
                },
            ])
            ->withSum([
                'transactions as total_quantity' => function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);
                },
            ], 'quantity')
            ->withSum([
                'transactions as total_amount' => function ($q) use ($from, $to) {
                    $q->whereBetween('created_at', [$from, $to]);
                },
            ], 'total_amount');

        if (array_key_exists('is_active', $data)) {
            $query->where('is_active', (bool) $data['is_active']);
        }

        $items = $query
            ->orderByDesc('total_amount')
            ->limit($limit)
            ->get()
            ->map(function (Supplier $supplier) {
                return [
                    'id' => $supplier->id,
                    'name' => $supplier->name,
                    'contact_person' => $supplier->contact_person,
                    'email' => $supplier->email,
                    'phone' => $supplier->phone,
                    'is_active' => (bool) $supplier->is_active,
                    'transaction_count' => (int) $supplier->transaction_count,
                    'total_quantity' => (int) ($supplier->total_quantity ?? 0),
                    'total_amount' => (float) ($supplier->total_amount ?? 0),
                ];
            })
            ->values();

        return response()->json([
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ]);

        $supplier->update($data);

        return response()->json([
            'message' => 'Supplier updated successfully',
            'supplier' => $supplier,
        ]);
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists() || $supplier->inventory()->exists() || $supplier->transactions()->exists()) {
            return response()->json([
                'message' => 'Cannot delete supplier with associated records',
            ], 400);
        }

        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}
