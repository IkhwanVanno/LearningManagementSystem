<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('class_statuses')->insert([
            ['name' => 'draft'],
            ['name' => 'active'],
            ['name' => 'archived'],
        ]);
    }
}
