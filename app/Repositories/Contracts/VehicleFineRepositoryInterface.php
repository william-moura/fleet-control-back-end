<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateVehicleFineDTO;
use App\Models\VehicleFine;
use Illuminate\Pagination\LengthAwarePaginator;

interface VehicleFineRepositoryInterface
{
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createVehicleFine(CreateVehicleFineDTO $dto): VehicleFine;
    public function updateVehicleFine(int $id, CreateVehicleFineDTO $dto): VehicleFine;
    public function destroyVehicleFine(int $id): void;
    public function showVehicleFine(int $id): VehicleFine;
    public function totalFinesByMonth(): float;
}