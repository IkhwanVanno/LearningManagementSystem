<?php

namespace Database\Seeders;

use App\Models\ClassMember;
use App\Models\ClassMemberStatus;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = User::whereHas('role', fn($q) => $q->where('name', 'Student'))->first();
        $class = ClassRoom::first();
        $approved = ClassMemberStatus::where('name', 'approved')->first();

        ClassMember::create([
            'class_id' => $class->id,
            'student_id' => $student->id,
            'status_id' => $approved->id,
            'joined_at' => now(),
        ]);
    }
}
