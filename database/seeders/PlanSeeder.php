<?php

namespace Database\Seeders;

use App\Models\Plan;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i=0; $i < 6; $i++) {
            Plan::create([
                'name' => $faker->text(10),
                'description' => $faker->paragraph(3),
                'price' => $faker->randomFloat(2,50,200),
                'allow_exam' => $faker->randomNumber(2),
                'allow_question' => $faker->randomNumber(2),
                'for_student' => $faker->boolean(),
                'status' => $faker->boolean()
            ]);
        }
    }
}
