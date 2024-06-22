<?php

namespace Database\Seeders;

use App\Models\Group;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Factory::create();
        for ($i=0; $i < 5; $i++) {
            Group::create([
                'name' => $faker->unique()->text(10),
                'status' => $faker->randomElement([true,false])
            ]);
        }
    }
}
