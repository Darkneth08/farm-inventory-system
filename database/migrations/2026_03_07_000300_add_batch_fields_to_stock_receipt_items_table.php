<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('stock_receipt_items')) {
            return;
        }

        Schema::table('stock_receipt_items', function (Blueprint $table) {
            if (!Schema::hasColumn('stock_receipt_items', 'batch_number')) {
                $table->string('batch_number', 100)->nullable()->after('product_id');
            }

            if (!Schema::hasColumn('stock_receipt_items', 'manufacturing_date')) {
                $table->date('manufacturing_date')->nullable()->after('batch_number');
            }

            if (!Schema::hasColumn('stock_receipt_items', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('manufacturing_date');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('stock_receipt_items')) {
            return;
        }

        Schema::table('stock_receipt_items', function (Blueprint $table) {
            if (Schema::hasColumn('stock_receipt_items', 'expiry_date')) {
                $table->dropColumn('expiry_date');
            }

            if (Schema::hasColumn('stock_receipt_items', 'manufacturing_date')) {
                $table->dropColumn('manufacturing_date');
            }

            if (Schema::hasColumn('stock_receipt_items', 'batch_number')) {
                $table->dropColumn('batch_number');
            }
        });
    }
};
