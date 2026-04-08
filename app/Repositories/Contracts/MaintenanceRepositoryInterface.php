<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateMaintenanceControlDTO;
use App\Models\MaintenanceControl;
use Illuminate\Database\Eloquent\Collection;

interface MaintenanceRepositoryInterface
{
    public function index(): Collection;
    public function createMaintenance(CreateMaintenanceControlDTO $dto): MaintenanceControl;
    public function updateMaintenance(int $id, CreateMaintenanceControlDTO $dto): MaintenanceControl;
    public function destroyMaintenance(int $id): void;
    public function showMaintenance(int $id): MaintenanceControl;
}