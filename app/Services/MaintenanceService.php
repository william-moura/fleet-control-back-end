<?php

namespace App\Services;

use App\DTOs\CreateMaintenanceControlDTO;
use App\DTOs\CreateMaintenanceServiceDTO;
use App\DTOs\MaintenanceResponseDTO;
use App\DTOs\MaintenanceServiceResponseDTO;
use App\Models\MaintenanceControl;
use App\Models\MaintenanceControlService;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use App\Repositories\Contracts\MaintenanceServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceService
{
    public function __construct(
        protected MaintenanceRepositoryInterface $maintenanceRepository, 
        protected MaintenanceServiceRepositoryInterface $maintenanceServiceRepository
    ){
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $maintenances = $this->maintenanceRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $maintenances->through(fn(MaintenanceControl $maintenance) => MaintenanceResponseDTO::fromEntity($maintenance));
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

    public function indexMaintenanceServices(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $maintenanceServices = $this->maintenanceServiceRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $maintenanceServices->through(fn(MaintenanceControlService $maintenanceService) => MaintenanceServiceResponseDTO::fromEntity($maintenanceService));
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