<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const ROLES = ['super_admin', 'admin', 'manager', 'staff', 'customer'];

    public function index(Request $request)
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:255',
            'role' => ['nullable', Rule::in(self::ROLES)],
            'per_page' => 'nullable|integer|min:1|max:200',
        ]);

        $query = User::query()->select(['id', 'name', 'email', 'role', 'created_at']);

        if (!empty($data['search'])) {
            $search = $data['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if (!empty($data['role'])) {
            $query->where('role', $data['role']);
        }

        $perPage = $data['per_page'] ?? 20;

        return response()->json(
            $query->orderBy('name')->paginate($perPage)->appends($request->query())
        );
    }

    public function store(Request $request)
    {
        $actor = $request->user();
        $allowedRoles = $this->assignableRoles($actor);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in($allowedRoles)],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'role_id' => $this->resolveRoleId($data['role']),
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->only(['id', 'name', 'email', 'role', 'created_at']),
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json($user->only(['id', 'name', 'email', 'role', 'created_at']));
    }

    public function update(Request $request, User $user)
    {
        $actor = $request->user();
        $allowedRoles = $this->assignableRoles($actor);

        if ($actor->role !== 'super_admin' && $user->role === 'super_admin') {
            return response()->json(['message' => 'Only super admins can manage super admin accounts'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => ['required', Rule::in($allowedRoles)],
            'password' => 'nullable|string|min:8',
        ]);

        if ($actor->id === $user->id && $actor->role !== 'super_admin' && $data['role'] !== $user->role) {
            return response()->json(['message' => 'You cannot change your own role'], 422);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->role_id = $this->resolveRoleId($data['role']);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->only(['id', 'name', 'email', 'role', 'created_at']),
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json(['message' => 'You cannot delete your own account'], 422);
        }

        if ($request->user()->role !== 'super_admin' && $user->role === 'super_admin') {
            return response()->json(['message' => 'Only super admins can delete super admin accounts'], 403);
        }

        if ($user->role === 'super_admin' && User::where('role', 'super_admin')->count() <= 1) {
            return response()->json(['message' => 'At least one super admin account must remain'], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    private function assignableRoles(User $actor): array
    {
        if ($actor->role === 'super_admin') {
            return self::ROLES;
        }

        return ['admin', 'manager', 'staff', 'customer'];
    }

    private function resolveRoleId(string $role): ?int
    {
        if (!Schema::hasTable('roles')) {
            return null;
        }

        return Role::resolveId($role);
    }
}
