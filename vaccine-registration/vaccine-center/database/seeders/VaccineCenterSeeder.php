<?php

namespace VaccineRegistration\VaccineCenter\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use VaccineRegistration\VaccineCenter\Models\VaccineCenter;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            VaccineCenter::create([
                'name' => 'Center ' . $i,
                'daily_limit' => $faker->numberBetween(50, 300),
            ]);
        }
    }
}
