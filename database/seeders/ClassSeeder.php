<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\ClassStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mentor = User::whereHas('role', fn ($q) => $q->where('name', 'Mentor'))->first();
        $activeStatus = ClassStatus::where('name', 'active')->first();

        ClassRoom::create([
            'mentor_id' => $mentor->id,
            'title' => 'Laravel Dasar',
            'description' => 'Belajar dasar Laravel dari nol',
            'status_id' => $activeStatus->id,
        ]);

        ClassRoom::create([
            'mentor_id' => $mentor->id,
            'title' => 'REST API Laravel',
            'description' => 'Membangun REST API dengan Laravel',
            'status_id' => $activeStatus->id,
        ]);
    }
}
