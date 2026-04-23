<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Seeds', 'slug' => 'seeds', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fertilizers', 'slug' => 'fertilizers', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pesticides', 'slug' => 'pesticides', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Equipment', 'slug' => 'equipment', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}