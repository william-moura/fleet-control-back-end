<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateFuelSupplierDTO;
use App\Models\FuelSupplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface FuelSupplierRepositoryInterface
{
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createFuelSupplier(CreateFuelSupplierDTO $dto): FuelSupplier;
    public function updateFuelSupplier(int $id, CreateFuelSupplierDTO $dto): ?FuelSupplier;
    public function destroyFuelSupplier(int $id): void;
    public function showFuelSupplier(int $id): FuelSupplier;
    public function lastsFuelSuppliers(): Collection;
    public function totalFuelSuppliers(): float;
    public function totalFuelSuppliersByMonth(): float;
    public function getFuelSuppliersByVehicle(int $id): Collection;
}