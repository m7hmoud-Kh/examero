<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i=0; $i < 5; $i++) {
            QuestionType::create([
                'name' => $faker->unique()->text(10),
                'status' => $faker->randomElement([true,false])
            ]);
        }
    }
}
