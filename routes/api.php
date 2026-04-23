<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CategoryController,
    ProductController,
    InventoryController,
    SupplierController,
    WarehouseController,
    TransactionController,
    UserController,
    DashboardController,
    ReportController,
    SuperAdminController,
    CustomerController,
    PosController,
    OrderController,
    FavoriteController,
    ProductReviewController,
    UserNotificationController,
    PromotionController,
    StockReceiptController,
    BranchController,
    SmartFeatureController
};

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Customer self-service features
    Route::middleware('role:customer')->prefix('customer')->group(function () {
        Route::get('/profile', [CustomerController::class, 'profile']);
        Route::put('/profile', [CustomerController::class, 'updateProfile']);
        Route::put('/change-password', [CustomerController::class, 'changePassword']);

        Route::get('/requests', [CustomerController::class, 'requests']);
        Route::post('/requests', [CustomerController::class, 'storeRequest']);
        Route::delete('/requests/{customerRequest}', [CustomerController::class, 'cancelRequest'])->whereNumber('customerRequest');

        Route::get('/orders', [OrderController::class, 'customerIndex']);
        Route::post('/orders', [OrderController::class, 'customerStore']);
        Route::get('/orders/{order}', [OrderController::class, 'customerShow'])->whereNumber('order');

        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->whereNumber('product');
        Route::get('/alerts/favorites-low-stock', [FavoriteController::class, 'lowStockAlerts']);

        Route::get('/notifications', [UserNotificationController::class, 'index']);
        Route::patch('/notifications/read-all', [UserNotificationController::class, 'markAllAsRead']);
        Route::patch('/notifications/{notification}/read', [UserNotificationController::class, 'markAsRead'])->whereNumber('notification');

        Route::get('/reviews', [ProductReviewController::class, 'myReviews']);
        Route::post('/reviews', [ProductReviewController::class, 'storeOrUpdate']);
    });

    // Catalog read endpoints (customer and above)
    Route::middleware('role:customer,staff,manager,admin,super_admin')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->whereNumber('category');

        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{product}', [ProductController::class, 'show'])->whereNumber('product');
        Route::get('/products/{product}/reviews', [ProductReviewController::class, 'productReviews'])->whereNumber('product');

        Route::get('/promotions', [PromotionController::class, 'index']);
        Route::get('/smart/seasonal-suggestions', [SmartFeatureController::class, 'seasonalSuggestions']);
    });

    // Staff and above
    Route::middleware('role:staff,manager,admin,super_admin')->group(function () {
        Route::get('/pos/catalog', [PosController::class, 'catalog']);
        Route::get('/pos/warehouses', [PosController::class, 'warehouses']);
        Route::get('/pos/recent-sales', [PosController::class, 'recentSales']);
        Route::post('/pos/checkout', [PosController::class, 'checkout']);

        Route::get('/products/summary', [ProductController::class, 'summary']);
        Route::get('/products/reorder-suggestions', [ProductController::class, 'reorderSuggestions']);
        Route::get('/products/{product}/stock-history', [ProductController::class, 'stockHistory'])->whereNumber('product');

        Route::get('/inventory', [InventoryController::class, 'index']);
        Route::get('/inventory/summary', [InventoryController::class, 'summary']);
        Route::get('/inventory/warehouse-summary', [InventoryController::class, 'warehouseSummary']);
        Route::get('/inventory/batches', [InventoryController::class, 'batches']);
        Route::get('/inventory/aging', [InventoryController::class, 'aging']);
        Route::get('/inventory/low-stock', [InventoryController::class, 'lowStockReport']);
        Route::get('/inventory/expiring-soon', [InventoryController::class, 'expiringSoon']);
        Route::patch('/inventory/{inventory}/status', [InventoryController::class, 'updateStatus'])->whereNumber('inventory');
        Route::get('/inventory/{inventory}', [InventoryController::class, 'show'])->whereNumber('inventory');

        Route::get('/suppliers', [SupplierController::class, 'index']);
        Route::get('/suppliers/performance', [SupplierController::class, 'performance']);
        Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);

        Route::get('/warehouses', [WarehouseController::class, 'index']);
        Route::get('/warehouses/{warehouse}', [WarehouseController::class, 'show']);
        Route::get('/branches', [BranchController::class, 'index']);
        Route::get('/branches/{branch}', [BranchController::class, 'show']);

        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/summary', [TransactionController::class, 'summary']);
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);

        Route::get('/orders', [OrderController::class, 'adminIndex']);
        Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->whereNumber('order');
        Route::patch('/orders/{order}/status', [OrderController::class, 'adminUpdateStatus'])->whereNumber('order');

        Route::get('/stock-receipts', [StockReceiptController::class, 'index']);
        Route::post('/stock-receipts', [StockReceiptController::class, 'store']);

        Route::get('/reports/low-stock', [ReportController::class, 'lowStock']);
        Route::get('/reports/sales', [ReportController::class, 'sales']);
        Route::get('/reports/inventory-value', [ReportController::class, 'inventoryValue']);
        Route::get('/reports/expiring-stock', [ReportController::class, 'expiringStock']);
        Route::get('/reports/movement-summary', [ReportController::class, 'movementSummary']);
        Route::get('/reports/business-overview', [ReportController::class, 'businessOverview']);
        Route::get('/smart/forecast', [SmartFeatureController::class, 'forecastDemand']);
        Route::get('/smart/branches/overview', [SmartFeatureController::class, 'branchInventoryOverview']);
        Route::post('/transactions', [TransactionController::class, 'store']);
        Route::patch('/transactions/{transaction}', [TransactionController::class, 'update']);
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy']);

        Route::post('/inventory/adjust', [InventoryController::class, 'adjustStock']);
        Route::post('/inventory/transfer', [InventoryController::class, 'transferStock']);
    });

    // Manager and above
    Route::middleware('role:manager,admin,super_admin')->group(function () {
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::patch('/products/{product}/toggle-active', [ProductController::class, 'toggleActive']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::post('/suppliers', [SupplierController::class, 'store']);
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);
        Route::patch('/suppliers/{supplier}', [SupplierController::class, 'update']);
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']);

        Route::post('/inventory', [InventoryController::class, 'store']);
        Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);
        Route::patch('/inventory/{inventory}', [InventoryController::class, 'update']);
        Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy']);

        Route::post('/branches', [BranchController::class, 'store']);
        Route::put('/branches/{branch}', [BranchController::class, 'update']);
        Route::patch('/branches/{branch}', [BranchController::class, 'update']);
        Route::delete('/branches/{branch}', [BranchController::class, 'destroy']);

        Route::post('/warehouses', [WarehouseController::class, 'store']);
        Route::put('/warehouses/{warehouse}', [WarehouseController::class, 'update']);
        Route::patch('/warehouses/{warehouse}', [WarehouseController::class, 'update']);
        Route::delete('/warehouses/{warehouse}', [WarehouseController::class, 'destroy']);

        Route::post('/promotions', [PromotionController::class, 'store']);
        Route::put('/promotions/{promotion}', [PromotionController::class, 'update']);
        Route::patch('/promotions/{promotion}', [PromotionController::class, 'update']);
        Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy']);
    });

    // Admin and super admin
    Route::middleware('role:admin,super_admin')->group(function () {
        Route::apiResource('users', UserController::class)->except(['create', 'edit']);
    });

    // Super admin only controls
    Route::middleware('role:super_admin')->prefix('super-admin')->group(function () {
        Route::get('/overview', [SuperAdminController::class, 'overview']);
        Route::get('/role-distribution', [SuperAdminController::class, 'roleDistribution']);
        Route::get('/user-activity', [SuperAdminController::class, 'userActivity']);
        Route::get('/stale-accounts', [SuperAdminController::class, 'staleAccounts']);
        Route::get('/security-report', [SuperAdminController::class, 'securityReport']);
        Route::get('/login-activities', [SuperAdminController::class, 'loginActivities']);
        Route::get('/audit-logs', [SuperAdminController::class, 'auditLogs']);
        Route::get('/system-settings', [SuperAdminController::class, 'systemSettings']);
        Route::put('/system-settings', [SuperAdminController::class, 'upsertSystemSetting']);
        Route::get('/backup/export', [SuperAdminController::class, 'backupExport']);

        Route::post('/users', [SuperAdminController::class, 'createPrivilegedUser']);
        Route::post('/users/{user}/reset-password', [SuperAdminController::class, 'resetUserPassword']);
        Route::post('/users/{user}/revoke-tokens', [SuperAdminController::class, 'revokeUserTokens']);
        Route::post('/users/bulk-role', [SuperAdminController::class, 'bulkRoleUpdate']);
        Route::patch('/users/{user}/status', [SuperAdminController::class, 'updateUserStatus']);
        Route::patch('/users/{user}/permissions', [SuperAdminController::class, 'updateUserPermissions']);

        Route::get('/export/users.csv', [SuperAdminController::class, 'exportUsersCsv']);
    });
});

