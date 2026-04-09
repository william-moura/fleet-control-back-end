<?php

namespace App\Repositories\Contracts;

use App\Models\MaintenanceControlService;
use Illuminate\Database\Eloquent\Collection;
use App\DTOs\CreateMaintenanceServiceDTO;

interface MaintenanceServiceRepositoryInterface
{
    public function index(): Collection;
    public function createMaintenanceService(CreateMaintenanceServiceDTO $dto): MaintenanceControlService;
    public function updateMaintenanceService(int $id, CreateMaintenanceServiceDTO $dto): MaintenanceControlService;
    public function destroyMaintenanceService(int $id): void;
    public function showMaintenanceService(int $id): MaintenanceControlService;
}