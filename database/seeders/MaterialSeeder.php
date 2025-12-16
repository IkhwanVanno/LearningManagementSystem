<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = ClassRoom::first();
        $textType = MaterialType::where('name', 'text')->first();

        Material::create([
            'class_id' => $class->id,
            'title' => 'Pengenalan Laravel',
            'content' => 'Laravel adalah framework PHP modern...',
            'type_id' => $textType->id,
        ]);

        Material::create([
            'class_id' => $class->id,
            'title' => 'Routing & Controller',
            'content' => 'Membahas routing, controller, dan request...',
            'type_id' => $textType->id,
        ]);
    }
}
