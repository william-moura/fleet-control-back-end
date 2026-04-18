<?php

namespace App\Repositories\Contracts;

use App\Models\MaintenanceControlService;
use Illuminate\Pagination\LengthAwarePaginator;
use App\DTOs\CreateMaintenanceServiceDTO;

interface MaintenanceServiceRepositoryInterface
{
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator;
    public function createMaintenanceService(CreateMaintenanceServiceDTO $dto): MaintenanceControlService;
    public function updateMaintenanceService(int $id, CreateMaintenanceServiceDTO $dto): MaintenanceControlService;
    public function destroyMaintenanceService(int $id): void;
    public function showMaintenanceService(int $id): MaintenanceControlService;
}