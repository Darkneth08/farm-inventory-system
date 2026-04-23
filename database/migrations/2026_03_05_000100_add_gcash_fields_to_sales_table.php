<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('sales')) {
            return;
        }

        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'gcash_reference_number')) {
                $table->string('gcash_reference_number')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('sales', 'gcash_receipt_image_path')) {
                $table->string('gcash_receipt_image_path')->nullable()->after('gcash_reference_number');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sales')) {
            return;
        }

        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'gcash_receipt_image_path')) {
                $table->dropColumn('gcash_receipt_image_path');
            }

            if (Schema::hasColumn('sales', 'gcash_reference_number')) {
                $table->dropColumn('gcash_reference_number');
            }
        });
    }
};
