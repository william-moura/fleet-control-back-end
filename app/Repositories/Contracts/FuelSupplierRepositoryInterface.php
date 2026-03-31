<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateFuelSupplierDTO;
use App\Models\FuelSupplier;
use Illuminate\Database\Eloquent\Collection;

interface FuelSupplierRepositoryInterface
{
    public function index(): Collection;
    public function createFuelSupplier(CreateFuelSupplierDTO $dto): FuelSupplier;
    public function updateFuelSupplier(int $id, CreateFuelSupplierDTO $dto): ?FuelSupplier;
    public function destroyFuelSupplier(int $id): void;
    public function showFuelSupplier(int $id): FuelSupplier;
}