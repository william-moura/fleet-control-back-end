<?php

namespace App\Services;

use App\Models\FuelType;
use App\Repositories\Contracts\FuelTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FuelTypeService
{
    public function __construct(protected FuelTypeRepositoryInterface $fuelTypeRepository)
    {
    }
    public function index(): Collection
    {
        return $this->fuelTypeRepository->index();
    }
    public function store(string $fuelTypeName): FuelType
    {
        $fuelType = FuelType::create([
            'fuel_type_name' => $fuelTypeName,
        ]);
        return $fuelType;
    }
}