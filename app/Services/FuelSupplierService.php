<?php

namespace App\Services;

use App\DTOs\CreateFuelSupplierDTO;
use App\Models\FuelSupplier;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FuelSupplierService
{
    public function __construct(protected FuelSupplierRepositoryInterface $fuelSupplierRepository)
    {
    }
    public function index(): Collection
    {
        return $this->fuelSupplierRepository->index();
    }
    public function createFuelSupplier(CreateFuelSupplierDTO $dto): FuelSupplier
    {
        return $this->fuelSupplierRepository->createFuelSupplier($dto);
    }
    public function updateFuelSupplier(int $id, CreateFuelSupplierDTO $dto): FuelSupplier
    {
        return $this->fuelSupplierRepository->updateFuelSupplier($id, $dto);
    }
    public function destroyFuelSupplier(int $id): void
    {
        $this->fuelSupplierRepository->destroyFuelSupplier($id);
    }
    public function showFuelSupplier(int $id): FuelSupplier
    {
        return $this->fuelSupplierRepository->showFuelSupplier($id);
    }
}