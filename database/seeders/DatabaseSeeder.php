<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CustomerRequest;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roleIds = [];
        if (Schema::hasTable('roles')) {
            foreach (['super_admin', 'admin', 'manager', 'staff', 'customer'] as $roleName) {
                $role = Role::firstOrCreate(['role_name' => $roleName]);
                $roleIds[$roleName] = $role->id;
            }
        }

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@farm.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'role_id' => $roleIds['super_admin'] ?? null,
                'status' => 'active',
            ]
        );
        $admin = User::firstOrCreate(
            ['email' => 'admin@farm.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'role_id' => $roleIds['admin'] ?? null,
                'status' => 'active',
            ]
        );
        $manager = User::firstOrCreate(
            ['email' => 'manager@farm.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'role_id' => $roleIds['manager'] ?? null,
                'status' => 'active',
            ]
        );
        $staff = User::firstOrCreate(
            ['email' => 'staff@farm.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'role_id' => $roleIds['staff'] ?? null,
                'status' => 'active',
            ]
        );
        $customer = User::firstOrCreate(
            ['email' => 'customer@farm.com'],
            [
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'role_id' => $roleIds['customer'] ?? null,
                'status' => 'active',
            ]
        );

        $categories = [
            ['name' => 'Seeds', 'description' => 'All types of farming seeds'],
            ['name' => 'Fertilizers', 'description' => 'Organic and chemical fertilizers'],
            ['name' => 'Pesticides', 'description' => 'Insecticides and fungicides'],
            ['name' => 'Equipment', 'description' => 'Farming tools and equipment'],
            ['name' => 'Animal Feed', 'description' => 'Feed for livestock'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                ['name' => $cat['name'], 'description' => $cat['description'], 'is_active' => true]
            );
        }

        $supplierA = Supplier::firstOrCreate(
            ['email' => 'contact@agrisupply.com'],
            [
                'name' => 'AgriSupply Co.',
                'contact_person' => 'John Doe',
                'phone' => '123-456-7890',
                'address' => '123 Farm Road',
                'is_active' => true,
            ]
        );
        $supplierB = Supplier::firstOrCreate(
            ['email' => 'sales@farmessentials.com'],
            [
                'name' => 'Farm Essentials Ltd',
                'contact_person' => 'Jane Smith',
                'phone' => '098-765-4321',
                'address' => '456 Harvest Lane',
                'is_active' => true,
            ]
        );

        $mainWarehouse = Warehouse::firstOrCreate(
            ['code' => 'WH-MAIN'],
            ['name' => 'Main Warehouse', 'location' => 'North Farm Block', 'manager_name' => 'Michael Smith', 'phone' => '555-0101', 'is_active' => true]
        );
        $secondaryWarehouse = Warehouse::firstOrCreate(
            ['code' => 'WH-EAST'],
            ['name' => 'East Warehouse', 'location' => 'East Processing Zone', 'manager_name' => 'Jane Carter', 'phone' => '555-0102', 'is_active' => true]
        );

        $seedCategory = Category::where('slug', Str::slug('Seeds'))->first();
        $fertilizerCategory = Category::where('slug', Str::slug('Fertilizers'))->first();
        $fallbackCategoryId = Category::query()->value('id');

        $cornSeeds = Product::firstOrCreate(
            ['sku' => 'CS-001'],
            [
                'name' => 'Corn Seeds',
                'barcode' => '123456789',
                'category_id' => $seedCategory?->id ?? $fallbackCategoryId,
                'supplier_id' => $supplierA->id,
                'unit_price' => 25.50,
                'unit_of_measure' => 'kg',
                'current_stock' => 0,
                'min_stock_level' => 20,
                'max_stock_level' => 500,
                'reorder_point' => 30,
                'is_active' => true,
            ]
        );

        $organicFertilizer = Product::firstOrCreate(
            ['sku' => 'OF-001'],
            [
                'name' => 'Organic Fertilizer',
                'barcode' => '987654321',
                'category_id' => $fertilizerCategory?->id ?? $fallbackCategoryId,
                'supplier_id' => $supplierB->id,
                'unit_price' => 15.75,
                'unit_of_measure' => 'liter',
                'current_stock' => 0,
                'min_stock_level' => 50,
                'max_stock_level' => 1000,
                'reorder_point' => 75,
                'is_active' => true,
            ]
        );

        $inv1 = Inventory::firstOrCreate(
            ['product_id' => $cornSeeds->id, 'warehouse_id' => $mainWarehouse->id, 'batch_number' => 'BATCH-CS-001'],
            [
                'supplier_id' => $supplierA->id,
                'quantity' => 100,
                'unit_cost' => 19.50,
                'selling_price' => 25.50,
                'status' => 'available',
            ]
        );
        $inv2 = Inventory::firstOrCreate(
            ['product_id' => $organicFertilizer->id, 'warehouse_id' => $secondaryWarehouse->id, 'batch_number' => 'BATCH-OF-001'],
            [
                'supplier_id' => $supplierB->id,
                'quantity' => 220,
                'unit_cost' => 11.00,
                'selling_price' => 15.75,
                'status' => 'available',
            ]
        );

        $cornSeeds->update(['current_stock' => Inventory::where('product_id', $cornSeeds->id)->sum('quantity')]);
        $organicFertilizer->update(['current_stock' => Inventory::where('product_id', $organicFertilizer->id)->sum('quantity')]);

        Transaction::firstOrCreate(
            ['transaction_number' => 'TRX-SEED-INIT-001'],
            [
                'product_id' => $cornSeeds->id,
                'inventory_id' => $inv1->id,
                'transaction_type' => 'in',
                'quantity' => 100,
                'unit_price' => 19.50,
                'total_amount' => 1950,
                'warehouse_id' => $mainWarehouse->id,
                'user_id' => $superAdmin->id,
                'supplier_id' => $supplierA->id,
                'notes' => 'Initial seed stock',
            ]
        );
        Transaction::firstOrCreate(
            ['transaction_number' => 'TRX-FERT-INIT-001'],
            [
                'product_id' => $organicFertilizer->id,
                'inventory_id' => $inv2->id,
                'transaction_type' => 'in',
                'quantity' => 220,
                'unit_price' => 11.00,
                'total_amount' => 2420,
                'warehouse_id' => $secondaryWarehouse->id,
                'user_id' => $manager->id,
                'supplier_id' => $supplierB->id,
                'notes' => 'Initial fertilizer stock',
            ]
        );

        CustomerRequest::firstOrCreate(
            [
                'user_id' => $customer->id,
                'product_id' => $cornSeeds->id,
                'status' => 'pending',
            ],
            [
                'requested_quantity' => 25,
                'notes' => 'Need seeds for the next planting cycle.',
            ]
        );

        if (!User::where('role', 'staff')->where('id', $staff->id)->exists()) {
            $staff->update(['role' => 'staff']);
        }

        if (!User::where('role', 'admin')->where('id', $admin->id)->exists()) {
            $admin->update(['role' => 'admin']);
        }

        if (!User::where('role', 'customer')->where('id', $customer->id)->exists()) {
            $customer->update(['role' => 'customer']);
        }

        if (!empty($roleIds)) {
            $superAdmin->update(['role_id' => $roleIds['super_admin'] ?? null, 'status' => 'active']);
            $admin->update(['role_id' => $roleIds['admin'] ?? null, 'status' => 'active']);
            $manager->update(['role_id' => $roleIds['manager'] ?? null, 'status' => 'active']);
            $staff->update(['role_id' => $roleIds['staff'] ?? null, 'status' => 'active']);
            $customer->update(['role_id' => $roleIds['customer'] ?? null, 'status' => 'active']);
        }
    }
}
