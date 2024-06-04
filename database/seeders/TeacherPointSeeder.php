<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\TeacherPoint;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        $adminIds = Teacher::pluck('id');
        $status = [1,2,3];
        for ($i=0; $i < 20; $i++) {
            TeacherPoint::create([
                'message' => $faker->text(30),
                'points' => $faker->randomFloat(2,1,10),
                'type' => $faker->randomElement($status),
                'teacher_id' => $adminIds->random()
            ]);
        }
    }
}
