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
        if (Schema::hasTable('inventory')) {
            return;
        }

        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('batch_number')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->date('expiry_date')->nullable();
            $table->date('manufacturing_date')->nullable();
            $table->string('location_in_warehouse')->nullable();
            $table->string('status')->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'warehouse_id', 'batch_number'], 'inventory_unique_product_warehouse_batch');
            $table->index(['status', 'expiry_date']);
        });

        Schema::table('inventory', function (Blueprint $table) {
            if (Schema::hasTable('products')) {
                $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            }
            if (Schema::hasTable('warehouses')) {
                $table->foreign('warehouse_id')->references('id')->on('warehouses')->cascadeOnDelete();
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
        Schema::dropIfExists('inventory');
    }
};
