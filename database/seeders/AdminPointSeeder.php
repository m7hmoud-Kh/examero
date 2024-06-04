<?php

namespace Database\Seeders;

use App\Enums\AdminTypePoint;
use App\Models\Admin;
use App\Models\AdminPoint;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $adminIds = Admin::pluck('id');
        $status = [1,2,3,4];
        for ($i=0; $i < 20; $i++) {
            AdminPoint::create([
                'message' => $faker->text(30),
                'points' => $faker->randomNumber(2),
                'type' => $faker->randomElement($status),
                'admin_id' => $adminIds->random()
            ]);
        }
    }
}
