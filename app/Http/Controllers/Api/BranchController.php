<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:200',
        ]);

        $query = Branch::query()
            ->withCount('warehouses')
            ->orderBy('name');

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        if (array_key_exists('is_active', $data)) {
            $query->where('is_active', (bool) $data['is_active']);
        }

        $perPage = $data['per_page'] ?? 30;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:60|unique:branches,code',
            'location' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $branch = Branch::create([
            ...$data,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return response()->json([
            'message' => 'Branch created successfully.',
            'branch' => $branch->fresh(['warehouses']),
        ], 201);
    }

    public function show(Branch $branch)
    {
        return response()->json(
            $branch->load(['warehouses' => function ($query) {
                $query->withCount('inventory')->orderBy('name');
            }])->loadCount('warehouses')
        );
    }

    public function update(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:60|unique:branches,code,' . $branch->id,
            'location' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ]);

        $branch->update($data);

        return response()->json([
            'message' => 'Branch updated successfully.',
            'branch' => $branch->fresh()->loadCount('warehouses'),
        ]);
    }

    public function destroy(Branch $branch)
    {
        if ($branch->warehouses()->exists()) {
            return response()->json([
                'message' => 'Cannot delete branch with assigned warehouses.',
            ], 422);
        }

        $branch->delete();

        return response()->json([
            'message' => 'Branch deleted successfully.',
        ]);
    }
}
