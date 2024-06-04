<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            // AdminNoteSeeder::class,
            AdminPointSeeder::class,
            GroupSeeder::class,
            SubjectSeeder::class,
            UnitSeeder::class,
            LessonSeeder::class,
            QuestionTypeSeeder::class,
            TeacherSeeder::class,
            TeacherPointSeeder::class,
            PlanSeeder::class,
            QuestionSeeder::class

        ]);
    }
}
