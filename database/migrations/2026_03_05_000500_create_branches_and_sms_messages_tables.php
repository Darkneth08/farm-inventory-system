<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('branches')) {
            Schema::create('branches', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('location')->nullable();
                $table->string('contact_person')->nullable();
                $table->string('phone')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('warehouses') && !Schema::hasColumn('warehouses', 'branch_id')) {
            Schema::table('warehouses', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('id');
                $table->index('branch_id');
            });

            Schema::table('warehouses', function (Blueprint $table) {
                if (Schema::hasTable('branches')) {
                    $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('branches') && Schema::hasTable('warehouses') && Schema::hasColumn('warehouses', 'branch_id')) {
            $defaultBranchId = DB::table('branches')->where('code', 'MAIN')->value('id');
            if (!$defaultBranchId) {
                $defaultBranchId = DB::table('branches')->insertGetId([
                    'name' => 'Main Branch',
                    'code' => 'MAIN',
                    'location' => null,
                    'contact_person' => null,
                    'phone' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('warehouses')->whereNull('branch_id')->update(['branch_id' => $defaultBranchId]);
        }

    }

    public function down(): void
    {
        if (Schema::hasTable('warehouses') && Schema::hasColumn('warehouses', 'branch_id')) {
            Schema::table('warehouses', function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropIndex(['branch_id']);
                $table->dropColumn('branch_id');
            });
        }

        Schema::dropIfExists('branches');
    }
};
