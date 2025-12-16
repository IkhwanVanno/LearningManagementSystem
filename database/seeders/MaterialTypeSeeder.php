<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('material_types')->insert([
            ['name' => 'text'],
            ['name' => 'video'],
            ['name' => 'file'],
        ]);
    }
}
