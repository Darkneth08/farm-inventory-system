<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Inventory;
use App\Models\LoginActivity;
use App\Models\Product;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Warehouse;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    public function overview()
    {
        $inventoryValue = (float) Inventory::query()
            ->selectRaw('COALESCE(SUM(quantity * unit_cost), 0) as total')
            ->value('total');

        return response()->json([
            'users_total' => User::count(),
            'super_admins' => User::where('role', 'super_admin')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'managers' => User::where('role', 'manager')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'new_users_30_days' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'active_tokens' => DB::table('personal_access_tokens')->count(),
            'transactions_today' => Transaction::whereDate('created_at', today())->count(),
            'transactions_month' => Transaction::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'products_total' => Product::count(),
            'low_stock_products' => Product::whereRaw('current_stock <= reorder_point')->count(),
            'out_of_stock_products' => Product::where('current_stock', '<=', 0)->count(),
            'warehouses_total' => Warehouse::count(),
            'inventory_value' => $inventoryValue,
        ]);
    }

    public function roleDistribution()
    {
        $total = max(User::count(), 1);

        $items = User::query()
            ->selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row) use ($total) {
                return [
                    'role' => $row->role,
                    'total' => (int) $row->total,
                    'percentage' => round(((int) $row->total / $total) * 100, 2),
                ];
            })
            ->values();

        return response()->json([
            'total_users' => User::count(),
            'items' => $items,
        ]);
    }

    public function userActivity(Request $request)
    {
        $data = $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'limit' => 'nullable|integer|min:1|max:200',
        ]);

        $from = isset($data['from']) ? now()->parse($data['from'])->startOfDay() : now()->subDays(30)->startOfDay();
        $to = isset($data['to']) ? now()->parse($data['to'])->endOfDay() : now()->endOfDay();
        $limit = $data['limit'] ?? 25;

        if ($to->lt($from)) {
            return response()->json([
                'message' => 'The "to" date must be greater than or equal to the "from" date.',
            ], 422);
        }

        $items = User::query()
            ->leftJoin('transactions', function ($join) use ($from, $to) {
                $join->on('users.id', '=', 'transactions.user_id')
                    ->whereBetween('transactions.created_at', [$from, $to]);
            })
            ->selectRaw(
                'users.id, users.name, users.email, users.role,
                COUNT(transactions.id) as transaction_count,
                COALESCE(SUM(transactions.quantity), 0) as total_quantity,
                COALESCE(SUM(transactions.total_amount), 0) as total_amount,
                MAX(transactions.created_at) as last_activity_at'
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.role')
            ->orderByDesc('transaction_count')
            ->orderByDesc('total_amount')
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                return [
                    'id' => (int) $row->id,
                    'name' => $row->name,
                    'email' => $row->email,
                    'role' => $row->role,
                    'transaction_count' => (int) $row->transaction_count,
                    'total_quantity' => (int) $row->total_quantity,
                    'total_amount' => (float) $row->total_amount,
                    'last_activity_at' => $row->last_activity_at,
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

    public function staleAccounts(Request $request)
    {
        $data = $request->validate([
            'days' => 'nullable|integer|min:1|max:365',
            'limit' => 'nullable|integer|min:1|max:200',
        ]);

        $days = $data['days'] ?? 45;
        $limit = $data['limit'] ?? 50;
        $cutoff = now()->subDays($days)->startOfDay();

        $items = User::query()
            ->leftJoin('transactions', 'users.id', '=', 'transactions.user_id')
            ->selectRaw(
                'users.id, users.name, users.email, users.role,
                MAX(transactions.created_at) as last_activity_at,
                COUNT(transactions.id) as total_transactions'
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.role')
            ->havingRaw('MAX(transactions.created_at) IS NULL OR MAX(transactions.created_at) < ?', [$cutoff])
            ->orderByRaw('MAX(transactions.created_at) IS NULL DESC')
            ->orderBy('last_activity_at')
            ->limit($limit)
            ->get()
            ->map(function ($row) {
                return [
                    'id' => (int) $row->id,
                    'name' => $row->name,
                    'email' => $row->email,
                    'role' => $row->role,
                    'last_activity_at' => $row->last_activity_at,
                    'total_transactions' => (int) $row->total_transactions,
                ];
            })
            ->values();

        return response()->json([
            'older_than_days' => $days,
            'cutoff_date' => $cutoff->toDateString(),
            'count' => $items->count(),
            'items' => $items,
        ]);
    }

    public function securityReport()
    {
        $heavyTokenUsers = User::query()
            ->withCount('tokens')
            ->orderByDesc('tokens_count')
            ->limit(10)
            ->get(['id', 'name', 'email', 'role'])
            ->map(function (User $user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'tokens_count' => (int) $user->tokens_count,
                ];
            })
            ->values();

        return response()->json([
            'active_tokens' => DB::table('personal_access_tokens')->count(),
            'users_without_tokens' => User::doesntHave('tokens')->count(),
            'users_with_5plus_tokens' => User::has('tokens', '>=', 5)->count(),
            'new_users_7_days' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'transactions_without_user' => Transaction::whereNull('user_id')->count(),
            'top_token_users' => $heavyTokenUsers,
        ]);
    }

    public function createPrivilegedUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'manager', 'staff', 'customer'])],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'role_id' => $this->resolveRoleId($data['role']),
            'status' => 'active',
        ]);

        AuditLogger::log($request, 'super_admin_user_created', 'user', $user->id, [
            'role' => $user->role,
            'email' => $user->email,
        ]);

        return response()->json([
            'message' => 'Privileged account created successfully',
            'user' => $user->only(['id', 'name', 'email', 'role', 'created_at']),
        ], 201);
    }

    public function resetUserPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => 'required|string|min:8',
            'revoke_tokens' => 'nullable|boolean',
        ]);

        $user->password = Hash::make($data['password']);
        $user->save();

        if (($data['revoke_tokens'] ?? true) === true) {
            $user->tokens()->delete();
        }

        AuditLogger::log($request, 'super_admin_password_reset', 'user', $user->id, [
            'email' => $user->email,
            'revoked_tokens' => (bool) ($data['revoke_tokens'] ?? true),
        ]);

        return response()->json([
            'message' => 'Password reset successfully',
            'user' => $user->only(['id', 'name', 'email', 'role']),
        ]);
    }

    public function revokeUserTokens(Request $request, User $user)
    {
        $revokedCount = $user->tokens()->count();
        $user->tokens()->delete();

        AuditLogger::log($request, 'super_admin_revoke_tokens', 'user', $user->id, [
            'email' => $user->email,
            'revoked_tokens' => $revokedCount,
        ]);

        return response()->json([
            'message' => 'User tokens revoked successfully',
            'revoked_tokens' => $revokedCount,
            'user' => $user->only(['id', 'name', 'email', 'role']),
        ]);
    }

    public function bulkRoleUpdate(Request $request)
    {
        $data = $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer|exists:users,id',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'manager', 'staff', 'customer'])],
        ]);

        $userIds = array_values(array_unique(array_map('intval', $data['user_ids'])));
        $targetRole = $data['role'];

        $currentSuperAdmins = User::where('role', 'super_admin')->count();
        $superAdminsToBeChanged = User::whereIn('id', $userIds)->where('role', 'super_admin')->count();

        if ($targetRole !== 'super_admin' && ($currentSuperAdmins - $superAdminsToBeChanged) < 1) {
            return response()->json([
                'message' => 'At least one super admin account must remain.',
            ], 422);
        }

        $updated = User::whereIn('id', $userIds)->update(['role' => $targetRole]);

        if (Schema::hasTable('roles') && Schema::hasColumn('users', 'role_id')) {
            User::whereIn('id', $userIds)->update(['role_id' => $this->resolveRoleId($targetRole)]);
        }

        AuditLogger::log($request, 'super_admin_bulk_role_update', 'user', null, [
            'role' => $targetRole,
            'updated_users' => $updated,
            'user_ids' => $userIds,
        ]);

        return response()->json([
            'message' => 'Roles updated successfully',
            'updated_users' => $updated,
            'role' => $targetRole,
        ]);
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $data = $request->validate([
            'status' => 'required|in:active,suspended',
            'revoke_tokens' => 'nullable|boolean',
        ]);

        if ($user->role === 'super_admin' && $data['status'] !== 'active') {
            $activeSuperAdmins = User::query()
                ->where('role', 'super_admin')
                ->where('status', 'active')
                ->where('id', '!=', $user->id)
                ->count();

            if ($activeSuperAdmins < 1) {
                return response()->json([
                    'message' => 'At least one active super admin must remain.',
                ], 422);
            }
        }

        $user->status = $data['status'];
        $user->save();

        if ($data['status'] === 'suspended' || ($data['revoke_tokens'] ?? false)) {
            $user->tokens()->delete();
        }

        AuditLogger::log($request, 'super_admin_user_status_updated', 'user', $user->id, [
            'status' => $user->status,
        ]);

        return response()->json([
            'message' => 'User status updated successfully.',
            'user' => $user->only(['id', 'name', 'email', 'role', 'status']),
        ]);
    }

    public function updateUserPermissions(Request $request, User $user)
    {
        $data = $request->validate([
            'permissions' => 'nullable|array',
        ]);

        $permissions = $data['permissions'] ?? [];
        $sanitized = [];

        foreach ($permissions as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            $sanitized[$key] = (bool) $value;
        }

        $user->permissions_override = !empty($sanitized) ? $sanitized : null;
        $user->save();

        AuditLogger::log($request, 'super_admin_permissions_updated', 'user', $user->id, [
            'permissions_override' => $user->permissions_override,
        ]);

        return response()->json([
            'message' => 'User permission overrides updated successfully.',
            'user' => $user->only(['id', 'name', 'email', 'role', 'permissions_override']),
        ]);
    }

    public function systemSettings()
    {
        $rows = SystemSetting::query()
            ->with('updatedBy:id,name')
            ->orderBy('key')
            ->get();

        return response()->json([
            'count' => $rows->count(),
            'items' => $rows,
        ]);
    }

    public function upsertSystemSetting(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|max:120',
            'value' => 'nullable',
            'description' => 'nullable|string|max:255',
        ]);

        $setting = SystemSetting::query()->updateOrCreate(
            ['key' => $data['key']],
            [
                'value' => $data['value'],
                'description' => $data['description'] ?? null,
                'updated_by_user_id' => $request->user()->id,
            ]
        );

        AuditLogger::log($request, 'super_admin_setting_upserted', 'system_setting', $setting->id, [
            'key' => $setting->key,
        ]);

        return response()->json([
            'message' => 'System setting saved successfully.',
            'setting' => $setting->load('updatedBy:id,name'),
        ]);
    }

    public function loginActivities(Request $request)
    {
        $data = $request->validate([
            'action' => 'nullable|string|max:50',
            'user_id' => 'nullable|integer|exists:users,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'per_page' => 'nullable|integer|min:1|max:200',
        ]);

        $query = LoginActivity::query()->with('user:id,name,email,role')->latest('created_at');

        if (!empty($data['action'])) {
            $query->where('action', $data['action']);
        }
        if (!empty($data['user_id'])) {
            $query->where('user_id', $data['user_id']);
        }
        if (!empty($data['from'])) {
            $query->where('created_at', '>=', now()->parse($data['from'])->startOfDay());
        }
        if (!empty($data['to'])) {
            $query->where('created_at', '<=', now()->parse($data['to'])->endOfDay());
        }

        $perPage = $data['per_page'] ?? 50;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function auditLogs(Request $request)
    {
        $data = $request->validate([
            'action' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'per_page' => 'nullable|integer|min:1|max:200',
        ]);

        $query = AuditLog::query()->with('user:id,name,email,role')->latest('created_at');

        if (!empty($data['action'])) {
            $query->where('action', $data['action']);
        }
        if (!empty($data['user_id'])) {
            $query->where('user_id', $data['user_id']);
        }
        if (!empty($data['from'])) {
            $query->where('created_at', '>=', now()->parse($data['from'])->startOfDay());
        }
        if (!empty($data['to'])) {
            $query->where('created_at', '<=', now()->parse($data['to'])->endOfDay());
        }

        $perPage = $data['per_page'] ?? 50;

        return response()->json(
            $query->paginate($perPage)->appends($request->query())
        );
    }

    public function backupExport()
    {
        $tables = [
            'users',
            'roles',
            'categories',
            'suppliers',
            'products',
            'inventory',
            'warehouses',
            'transactions',
            'sales',
            'sale_items',
            'orders',
            'order_items',
            'customer_requests',
            'product_reviews',
            'promotions',
            'user_notifications',
        ];

        $filename = 'system-backup-' . now()->format('Ymd-His') . '.json';

        return response()->streamDownload(function () use ($tables) {
            $payload = [
                'generated_at' => now()->toDateTimeString(),
                'tables' => [],
            ];

            foreach ($tables as $table) {
                if (!Schema::hasTable($table)) {
                    continue;
                }

                $payload['tables'][$table] = DB::table($table)->get();
            }

            echo json_encode($payload, JSON_PRETTY_PRINT);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }

    public function exportUsersCsv()
    {
        $users = User::query()
            ->withCount('tokens')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'role', 'created_at']);

        $filename = 'users-export-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($users) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Tokens', 'Created At']);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->tokens_count,
                    optional($user->created_at)->toDateTimeString(),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function resolveRoleId(string $role): ?int
    {
        if (!Schema::hasTable('roles')) {
            return null;
        }

        return Role::resolveId($role);
    }
}
