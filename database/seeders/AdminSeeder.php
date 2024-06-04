<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['guard_name' => 'admin', 'name' => 'owner']);
        Role::create(['guard_name' => 'admin', 'name' => 'manager']);
        Role::create(['guard_name' => 'admin', 'name' => 'supervisor']);
        $faker = Factory::create();
        $owner = Admin::create([
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => 'khairymahmoud795@gmail.com',
            'password' => '123456asd',
            'phone_number' => '01143124020',
            'governorate' => 'assuit',
            'date_of_birth' => $faker->date()
        ]);
        $owner->assignRole('owner');
        for ($i=0; $i < 10 ; $i++) {
            $manager = Admin::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => '123456asd',
                'phone_number' => '01143124020',
                'governorate' => 'assuit',
                'date_of_birth' => $faker->date()
            ]);
            $manager->assignRole('manager');
        }
        for ($i=0; $i < 10 ; $i++) {
            $supervisor = Admin::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => '123456asd',
                'phone_number' => '01143124020',
                'governorate' => 'assuit',
                'date_of_birth' => $faker->date()
            ]);
            $supervisor->assignRole('supervisor');
        }

    }
}
