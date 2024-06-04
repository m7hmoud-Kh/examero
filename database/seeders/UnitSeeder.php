<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Unit;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Factory::create();
        $subjectIds = Subject::pluck('id');
        $groupIds = Group::pluck('id');

        for ($i=0; $i < 20; $i++) {
            Unit::create([
                'name' => $faker->unique()->name(),
                'status' => $faker->boolean(),
                'subject_id' => $subjectIds->random(),
                'group_id' => $groupIds->random()
            ]);
        }
    }
}
