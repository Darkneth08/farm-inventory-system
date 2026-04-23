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
            if (!Schema::hasColumn('sales', 'discount_type')) {
                $table->string('discount_type', 20)->default('none')->after('discount');
            }

            if (!Schema::hasColumn('sales', 'discount_id_number')) {
                $table->string('discount_id_number', 100)->nullable()->after('discount_type');
            }

            if (!Schema::hasColumn('sales', 'discount_id_image_path')) {
                $table->string('discount_id_image_path')->nullable()->after('discount_id_number');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('sales')) {
            return;
        }

        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'discount_id_image_path')) {
                $table->dropColumn('discount_id_image_path');
            }

            if (Schema::hasColumn('sales', 'discount_id_number')) {
                $table->dropColumn('discount_id_number');
            }

            if (Schema::hasColumn('sales', 'discount_type')) {
                $table->dropColumn('discount_type');
            }
        });
    }
};

