<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //test
        // $allPlans = Plan::where('for_student',true)->get();
        // User::all()->each(function ($user) use ($allPlans) {
        //     $user->plans()->attach(
        //         $allPlans->random(rand(1, 2))->pluck('id')->toArray()
        //     );
        // });
    }
}
