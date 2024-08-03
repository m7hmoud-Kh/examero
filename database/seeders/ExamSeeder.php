<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $allStudent = User::pluck('id');
        $groupIds = Group::pluck('id');
        $subjectIds = Subject::pluck('id');
        $unitIds = Unit::pluck('id');
        $lessonIds = Lesson::pluck('id');

        for ($i=0; $i < 100; $i++) {
            # code...
            $total_score = $faker->numberBetween(50, 100);

            // Generate a random result which is less than the total score
            $result = $faker->numberBetween(0, $total_score - 1);

            Exam::create([
                'user_id' => $allStudent->random(),
                'semster'  => $faker->randomElement([1,2]),
                'group_id' => $groupIds->random(),
                'subject_id' => $subjectIds->random(),
                'unit_id' => $unitIds->random(),
                'lesson_id' => $lessonIds->random(),
                'total_score' => $total_score,
                'result' => $result,
                'time_min' => $faker->numberBetween(5,70),
                'questions' => $faker->numberBetween(17,30)
            ]);
        }

    }
}
