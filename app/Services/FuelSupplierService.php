<?php

namespace App\Services;

use App\DTOs\CreateFuelSupplierDTO;
use App\DTOs\FuelSupplierResponseDTO;
use App\Models\FuelSupplier;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FuelSupplierService
{
    public function __construct(protected FuelSupplierRepositoryInterface $fuelSupplierRepository)
    {
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $fuelSuppliers = $this->fuelSupplierRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $fuelSuppliers->through(fn(FuelSupplier $fuelSupplier) => FuelSupplierResponseDTO::fromEntity($fuelSupplier));
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