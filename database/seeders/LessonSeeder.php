<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Unit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $unitIds = Unit::pluck('id');
        for ($i=0; $i < 30; $i++) {
            Lesson::create([
                'name' => $faker->unique()->text(10),
                'status' => $faker->randomElement([true,false]),
                'unit_id' => $unitIds->random()
            ]);
        }
    }
}
