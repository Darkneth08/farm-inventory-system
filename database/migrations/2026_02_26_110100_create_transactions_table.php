<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('transactions')) {
            return;
        }

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->enum('transaction_type', ['in', 'out', 'adjustment', 'transfer']);
            $table->integer('quantity');
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['transaction_type', 'created_at']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasTable('products')) {
                $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            }
            if (Schema::hasTable('inventory')) {
                $table->foreign('inventory_id')->references('id')->on('inventory')->nullOnDelete();
            }
            if (Schema::hasTable('warehouses')) {
                $table->foreign('warehouse_id')->references('id')->on('warehouses')->nullOnDelete();
            }
            if (Schema::hasTable('users')) {
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }
            if (Schema::hasTable('suppliers')) {
                $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
