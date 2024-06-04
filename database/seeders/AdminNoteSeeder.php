<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Admin;
use App\Models\AdminNote;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminNoteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $adminIds = Admin::pluck('id');
        for ($i=0; $i < 20; $i++) {
            AdminNote::create([
                'address' => $faker->text(10),
                'note' => $faker->text('150'),
                'admin_id' => $adminIds->random()
            ]);
        }
    }
}
