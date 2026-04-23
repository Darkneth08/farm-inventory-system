<?php

namespace App\Http\Controllers\Api;

use App\Models\LoginActivity;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $this->logLoginActivity(
                $user,
                $request->email,
                'login_failed',
                $request,
                ['reason' => 'invalid_credentials']
            );
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!Schema::hasTable('personal_access_tokens')) {
            return response()->json([
                'message' => 'Auth tokens table is missing. Run: php artisan migrate',
            ], 500);
        }

        try {
            $token = $user->createToken('auth-token')->plainTextToken;
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create login token. Run: php artisan migrate',
            ], 500);
        }

        $this->logLoginActivity($user, $user->email, 'login_success', $request);

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }

    public function logout(Request $request)
    {
        $this->logLoginActivity(
            $request->user(),
            $request->user()?->email,
            'logout',
            $request
        );

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            ...$user->toArray(),
            'permissions' => $this->resolvePermissions($user),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'role_id' => $this->resolveRoleId('customer'),
            'status' => 'active',
        ]);

        if (!Schema::hasTable('personal_access_tokens')) {
            return response()->json([
                'message' => 'Auth tokens table is missing. Run: php artisan migrate',
            ], 500);
        }

        try {
            $token = $user->createToken('auth-token')->plainTextToken;
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create registration token. Run: php artisan migrate',
            ], 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Registration successful'
        ], 201);
    }

    private function resolveRoleId(string $role): ?int
    {
        if (!Schema::hasTable('roles')) {
            return null;
        }

        return Role::resolveId($role);
    }

    private function resolvePermissions(User $user): array
    {
        $role = $user->role;
        $map = [
            'super_admin' => [
                'manage_users' => true,
                'manage_warehouses' => true,
                'manage_products' => true,
                'manage_inventory' => true,
                'manage_transactions' => true,
                'manage_orders' => true,
                'manage_promotions' => true,
                'manage_reviews' => true,
                'manage_suppliers' => true,
                'manage_branches' => true,
                'use_pos' => true,
                'view_smart_features' => true,
                'view_operations' => true,
                'view_reports' => true,
                'view_customer_features' => true,
                'view_notifications' => true,
                'view_orders' => true,
                'manage_settings' => true,
                'manage_security' => true,
                'manage_super_admin' => true,
            ],
            'admin' => [
                'manage_users' => true,
                'manage_warehouses' => true,
                'manage_products' => true,
                'manage_inventory' => true,
                'manage_transactions' => true,
                'manage_orders' => true,
                'manage_promotions' => true,
                'manage_reviews' => true,
                'manage_suppliers' => true,
                'manage_branches' => true,
                'use_pos' => true,
                'view_smart_features' => true,
                'view_operations' => true,
                'view_reports' => true,
                'view_customer_features' => true,
                'view_notifications' => true,
                'view_orders' => true,
                'manage_settings' => false,
                'manage_security' => false,
                'manage_super_admin' => false,
            ],
            'manager' => [
                'manage_users' => false,
                'manage_warehouses' => true,
                'manage_products' => true,
                'manage_inventory' => true,
                'manage_transactions' => true,
                'manage_orders' => true,
                'manage_promotions' => true,
                'manage_reviews' => true,
                'manage_suppliers' => true,
                'manage_branches' => true,
                'use_pos' => true,
                'view_smart_features' => true,
                'view_operations' => true,
                'view_reports' => true,
                'view_customer_features' => true,
                'view_notifications' => true,
                'view_orders' => true,
                'manage_settings' => false,
                'manage_security' => false,
                'manage_super_admin' => false,
            ],
            'staff' => [
                'manage_users' => false,
                'manage_warehouses' => false,
                'manage_products' => false,
                'manage_inventory' => true,
                'manage_transactions' => true,
                'manage_orders' => true,
                'manage_promotions' => false,
                'manage_reviews' => true,
                'manage_suppliers' => true,
                'manage_branches' => false,
                'use_pos' => true,
                'view_smart_features' => true,
                'view_operations' => true,
                'view_reports' => true,
                'view_customer_features' => true,
                'view_notifications' => true,
                'view_orders' => true,
                'manage_settings' => false,
                'manage_security' => false,
                'manage_super_admin' => false,
            ],
            'customer' => [
                'manage_users' => false,
                'manage_warehouses' => false,
                'manage_products' => false,
                'manage_inventory' => false,
                'manage_transactions' => false,
                'manage_orders' => false,
                'manage_promotions' => false,
                'manage_reviews' => true,
                'manage_suppliers' => false,
                'manage_branches' => false,
                'use_pos' => true,
                'view_smart_features' => true,
                'view_operations' => false,
                'view_reports' => false,
                'view_customer_features' => true,
                'view_notifications' => true,
                'view_orders' => true,
                'manage_settings' => false,
                'manage_security' => false,
                'manage_super_admin' => false,
            ],
        ];

        $base = $map[$role] ?? $map['customer'];
        $overrides = is_array($user->permissions_override ?? null)
            ? $user->permissions_override
            : [];

        return array_merge($base, $overrides);
    }

    private function logLoginActivity(?User $user, ?string $email, string $action, Request $request, array $meta = []): void
    {
        if (!Schema::hasTable('login_activities')) {
            return;
        }

        LoginActivity::create([
            'user_id' => $user?->id,
            'email' => $email,
            'action' => $action,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'meta' => $meta ?: null,
            'created_at' => now(),
        ]);
    }
}
