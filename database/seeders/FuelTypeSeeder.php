<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FuelType::insert([
            ['fuel_type_name' => 'Gasolina'],
            ['fuel_type_name' => 'Diesel'],
            ['fuel_type_name' => 'Elétrico'],
            ['fuel_type_name' => 'Etanol'],
            ['fuel_type_name' => 'Gás Natural Veicular (GNV)'],
            ['fuel_type_name' => 'Flex'],
        ]);
    }
}
