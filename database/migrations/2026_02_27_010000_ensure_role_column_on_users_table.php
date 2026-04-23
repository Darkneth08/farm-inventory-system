<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('staff')->after('password');
            });
        }

        if (Schema::hasTable('users')) {
            $hasSuperAdmin = DB::table('users')->where('role', 'super_admin')->exists();
            if (!$hasSuperAdmin) {
                $admin = DB::table('users')->where('role', 'admin')->orderBy('id')->first();
                if ($admin) {
                    DB::table('users')->where('id', $admin->id)->update(['role' => 'super_admin']);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
