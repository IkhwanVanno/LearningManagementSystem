<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = ClassRoom::first();

        Exercise::create([
            'class_id' => $class->id,
            'title' => 'Quiz Laravel Dasar',
            'description' => 'Latihan dasar Laravel',
        ]);
    }
}
