<?php

namespace App\Services;

use App\DTOs\CreateMaintenanceControlDTO;
use App\DTOs\CreateMaintenanceServiceDTO;
use App\Models\MaintenanceControl;
use App\Models\MaintenanceControlService;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use App\Repositories\Contracts\MaintenanceServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MaintenanceService
{
    public function __construct(
        protected MaintenanceRepositoryInterface $maintenanceRepository, 
        protected MaintenanceServiceRepositoryInterface $maintenanceServiceRepository
    ){
    }
    public function index(): Collection
    {
        return $this->maintenanceRepository->index();
    }
    public function createMaintenanceControl(CreateMaintenanceControlDTO $dto): MaintenanceControl
    {
        return $this->maintenanceRepository->createMaintenance($dto);
    }
    public function updateMaintenanceControl(int $id, CreateMaintenanceControlDTO $dto): MaintenanceControl
    {
        return $this->maintenanceRepository->updateMaintenance($id, $dto);
    }
    public function destroyMaintenanceControl(int $id): void
    {
        $this->maintenanceRepository->destroyMaintenance($id);
    }
    public function showMaintenanceControl(int $id): MaintenanceControl
    {
        return $this->maintenanceRepository->showMaintenance($id);
    }

    public function indexMaintenanceServices(): Collection
    {
        return $this->maintenanceServiceRepository->index();
    }
    public function createMaintenanceService(CreateMaintenanceServiceDTO $dto): MaintenanceControlService
    {
        return $this->maintenanceServiceRepository->createMaintenanceService($dto);
    }
    public function updateMaintenanceService(int $id, CreateMaintenanceServiceDTO $dto): MaintenanceControlService
    {
        return $this->maintenanceServiceRepository->updateMaintenanceService($id, $dto);
    }
    public function destroyMaintenanceService(int $id): void
    {
        $this->maintenanceServiceRepository->destroyMaintenanceService($id);
    }
    public function showMaintenanceService(int $id): MaintenanceControlService
    {
        return $this->maintenanceServiceRepository->showMaintenanceService($id);
    }
}