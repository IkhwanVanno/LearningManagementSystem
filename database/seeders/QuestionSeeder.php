<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercise = Exercise::first();

        Question::create([
            'exercise_id' => $exercise->id,
            'question_text' => 'Apa fungsi Artisan di Laravel?',
            'option_a' => 'Mengelola database',
            'option_b' => 'CLI untuk Laravel',
            'option_c' => 'Template engine',
            'option_d' => 'Routing system',
            'correct_answer' => 'B',
        ]);

        Question::create([
            'exercise_id' => $exercise->id,
            'question_text' => 'Command untuk membuat controller?',
            'option_a' => 'php artisan make:controller',
            'option_b' => 'php artisan controller:create',
            'option_c' => 'php artisan new controller',
            'option_d' => 'php artisan create:controller',
            'correct_answer' => 'A',
        ]);
    }
}
