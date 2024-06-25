<?php

namespace Database\Seeders;

use App\Models\OpenEmis;
use App\Models\Teacher;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpenEmisSeeder extends Seeder
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
        for ($i=0; $i < 100; $i++) {
            OpenEmis::create([
                'user_name' => $faker->text(7),
                'password' => $faker->password(maxLength:10),
                'group' => $faker->text(10),
                'subject' => $faker->text(7),
                'phone_number' => $faker->phoneNumber(),
                'status' => $faker->randomElement($status),
                'teacher_id' => $adminIds->random()
            ]);
        }
    }
}
