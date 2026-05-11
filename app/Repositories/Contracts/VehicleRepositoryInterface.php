<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateVehicleDTO;
use App\Models\Vehicle;
use Illuminate\Pagination\LengthAwarePaginator;

interface VehicleRepositoryInterface
{
    public function createVehicle(CreateVehicleDTO $to): Vehicle;
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function destroyVehicle($id): void;
    public function showVehicle($id): Vehicle;
    public function updateVehicle($id, CreateVehicleDTO $dto): Vehicle;
    public function count(): int;
    public function checkVechicleHasRelationship(int $id): bool;
}