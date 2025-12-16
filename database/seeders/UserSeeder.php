<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole   = Role::where('name', 'admin')->first();
        $mentorRole  = Role::where('name', 'mentor')->first();
        $studentRole = Role::where('name', 'student')->first();

        User::create([
            'name' => 'Admin LMS',
            'email' => 'admin@lms.test',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Mentor Demo',
            'email' => 'mentor@lms.test',
            'password' => Hash::make('password'),
            'role_id' => $mentorRole->id,
        ]);

        User::create([
            'name' => 'Student Demo',
            'email' => 'student@lms.test',
            'password' => Hash::make('password'),
            'role_id' => $studentRole->id,
        ]);
    }
}
