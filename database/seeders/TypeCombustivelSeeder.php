<?php

namespace Database\Seeders;

use App\Models\FuelType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeCombustivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FuelType::create(['fuel_type_name' => 'Gasolina']);
        FuelType::create(['fuel_type_name' => 'Álcool']);
        FuelType::create(['fuel_type_name' => 'Diesel']);
        FuelType::create(['fuel_type_name' => 'Gás Natural Veicular (GNV)']);
        FuelType::create(['fuel_type_name' => 'Gás Liquefeito de Petróleo (GLP)']);
        FuelType::create(['fuel_type_name' => 'Eletricidade']);
        FuelType::create(['fuel_type_name' => 'Híbrido']);
        FuelType::create(['fuel_type_name' => 'Outro']);
        FuelType::create(['fuel_type_name' => 'Flex']);
    }
}
