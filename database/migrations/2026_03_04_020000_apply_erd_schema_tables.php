<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('role_name')->unique();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('roles')) {
            $defaultRoles = ['super_admin', 'admin', 'manager', 'staff', 'customer'];
            foreach ($defaultRoles as $roleName) {
                DB::table('roles')->updateOrInsert(
                    ['role_name' => $roleName],
                    ['updated_at' => now(), 'created_at' => now()]
                );
            }
        }

        $addedRoleIdColumn = false;
        $addedStatusColumn = false;

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id')->nullable()->after('role');
            });
            $addedRoleIdColumn = true;
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('status')->default('active')->after('role_id');
            });
            $addedStatusColumn = true;
        }

        if (Schema::hasTable('users') && Schema::hasTable('roles') && Schema::hasColumn('users', 'role') && Schema::hasColumn('users', 'role_id')) {
            $roleMap = DB::table('roles')->pluck('id', 'role_name')->toArray();
            foreach ($roleMap as $roleName => $roleId) {
                DB::table('users')->where('role', $roleName)->update(['role_id' => $roleId]);
            }
        }

        if (Schema::hasTable('users') && $addedRoleIdColumn) {
            Schema::table('users', function (Blueprint $table) {
                $table->index(['role_id', 'status']);
                $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
            });
        } elseif (Schema::hasTable('users') && $addedStatusColumn && Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index(['role_id', 'status']);
            });
        }

        if (!Schema::hasTable('stock_receipts')) {
            Schema::create('stock_receipts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('supplier_id');
                $table->unsignedBigInteger('received_by_user_id');
                $table->timestamp('received_at')->useCurrent();
                $table->string('reference_no')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index(['supplier_id', 'received_at']);
                $table->unique('reference_no');
            });

            Schema::table('stock_receipts', function (Blueprint $table) {
                if (Schema::hasTable('suppliers')) {
                    $table->foreign('supplier_id')->references('id')->on('suppliers')->cascadeOnDelete();
                }
                if (Schema::hasTable('users')) {
                    $table->foreign('received_by_user_id')->references('id')->on('users')->cascadeOnDelete();
                }
            });
        }

        if (!Schema::hasTable('stock_receipt_items')) {
            Schema::create('stock_receipt_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('receipt_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity');
                $table->decimal('unit_cost', 12, 2);
                $table->decimal('line_total', 14, 2);
                $table->timestamps();

                $table->index(['receipt_id', 'product_id']);
            });

            Schema::table('stock_receipt_items', function (Blueprint $table) {
                if (Schema::hasTable('stock_receipts')) {
                    $table->foreign('receipt_id')->references('id')->on('stock_receipts')->cascadeOnDelete();
                }
                if (Schema::hasTable('products')) {
                    $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
                }
            });
        }

        if (!Schema::hasTable('sales')) {
            Schema::create('sales', function (Blueprint $table) {
                $table->id();
                $table->string('sale_number')->unique();
                $table->unsignedBigInteger('customer_user_id')->nullable();
                $table->unsignedBigInteger('cashier_user_id');
                $table->timestamp('sold_at')->useCurrent();
                $table->decimal('subtotal', 14, 2)->default(0);
                $table->decimal('discount', 14, 2)->default(0);
                $table->decimal('total', 14, 2)->default(0);
                $table->decimal('amount_paid', 14, 2)->default(0);
                $table->decimal('change_due', 14, 2)->default(0);
                $table->enum('payment_method', ['cash', 'gcash'])->default('cash');
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->index(['sold_at', 'payment_method']);
            });

            Schema::table('sales', function (Blueprint $table) {
                if (Schema::hasTable('users')) {
                    $table->foreign('customer_user_id')->references('id')->on('users')->nullOnDelete();
                    $table->foreign('cashier_user_id')->references('id')->on('users')->cascadeOnDelete();
                }
            });
        }

        if (!Schema::hasTable('sale_items')) {
            Schema::create('sale_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('sale_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity');
                $table->decimal('unit_price', 12, 2);
                $table->decimal('line_total', 14, 2);
                $table->timestamps();

                $table->index(['sale_id', 'product_id']);
            });

            Schema::table('sale_items', function (Blueprint $table) {
                if (Schema::hasTable('sales')) {
                    $table->foreign('sale_id')->references('id')->on('sales')->cascadeOnDelete();
                }
                if (Schema::hasTable('products')) {
                    $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
                }
            });
        }

        if (Schema::hasTable('transactions') && !Schema::hasColumn('transactions', 'sale_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('sale_id')->nullable()->after('reference_number');
                $table->index('sale_id');
            });

            if (Schema::hasTable('sales')) {
                Schema::table('transactions', function (Blueprint $table) {
                    $table->foreign('sale_id')->references('id')->on('sales')->nullOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('transactions') && Schema::hasColumn('transactions', 'sale_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['sale_id']);
                $table->dropIndex(['sale_id']);
                $table->dropColumn('sale_id');
            });
        }

        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('stock_receipt_items');
        Schema::dropIfExists('stock_receipts');

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                if (Schema::hasColumn('users', 'status')) {
                    $table->dropIndex(['role_id', 'status']);
                }
                $table->dropColumn('role_id');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        Schema::dropIfExists('roles');
    }
};
