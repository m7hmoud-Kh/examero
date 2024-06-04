<?php

namespace Database\Seeders;

use App\Models\Subject;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i=0; $i < 5; $i++) {
            Subject::create([
                'name' => $faker->text(10),
                'status' => $faker->randomElement([true,false])
            ]);
        }
    }
}
