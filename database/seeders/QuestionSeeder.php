<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lesson;
use App\Models\Option;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\Subject;
use App\Models\Unit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Factory::create();
        $groupIds = Group::pluck('id');
        $subjectIds = Subject::pluck('id');
        $unitIds = Unit::pluck('id');
        $lessonIds = Lesson::pluck('id');
        $questionTypeIds = QuestionType::pluck('id');
        $level = [1,2,3,4,5];
        $semster = [1,2];
        $for = [1,2,3];
        $status = [1,2,3];

        for ($i=0; $i < 100; $i++) {
            $question = Question::create([
                'name' => $faker->unique()->text(10),
                'point' => $faker->randomDigitNotZero(),
                'group_id' => $groupIds->random(),
                'subject_id' => $subjectIds->random(),
                'unit_id' => $unitIds->random(),
                'lesson_id' => $lessonIds->random(),
                'question_type_id' => $questionTypeIds->random(),
                'level' => $faker->randomElement($level),
                'semster' => $faker->randomElement($semster),
                'for' => $faker->randomElement($for),
                'status' => $faker->randomElement($status),
                'has_branch' => $faker->boolean(),
                'is_choose' => $faker->boolean()
            ]);
            for ($j=0; $j < 4; $j++) {
                Option::create([
                    'option' => $faker->text(10),
                    'is_correct' => $faker->boolean(),
                    'question_id' => $question->id
                ]);
            }
        }
    }
}
