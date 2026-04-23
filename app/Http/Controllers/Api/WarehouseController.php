<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $query = Warehouse::query()->with(['branch:id,name,code'])->withCount('inventory');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', (int) $request->branch_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        return response()->json($query->orderBy('name')->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'nullable|integer|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'location' => 'required|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $warehouse = Warehouse::create([
            ...$data,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return response()->json([
            'message' => 'Warehouse created successfully',
            'warehouse' => $warehouse->load('branch:id,name,code'),
        ], 201);
    }

    public function show(Warehouse $warehouse)
    {
        return response()->json(
            $warehouse->load(['branch:id,name,code', 'inventory.product'])->loadCount('inventory')
        );
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'branch_id' => 'nullable|integer|exists:branches,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'location' => 'required|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $warehouse->update($data);

        return response()->json([
            'message' => 'Warehouse updated successfully',
            'warehouse' => $warehouse->fresh()->load('branch:id,name,code'),
        ]);
    }

    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->inventory()->exists()) {
            return response()->json([
                'message' => 'Cannot delete warehouse with existing inventory records',
            ], 400);
        }

        $warehouse->delete();

        return response()->json(['message' => 'Warehouse deleted successfully']);
    }
}
