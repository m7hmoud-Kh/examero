<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i=0; $i < 10 ; $i++) {
            User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => '123456asd',
                'date_of_birth' => $faker->date(),
                'phone_number' => '01143124020',
                'is_block' => $faker->boolean(),
                'email_verified_at' => $faker->dateTime(),
            ]);
        }
    }
}
