<?php

namespace App\Services;

use App\DTOs\DashboardResponseDTO;
use App\DTOs\FuelSupplierResponseDTO;
use App\DTOs\MaintenanceResponseDTO;
use App\Models\FuelSupplier;
use App\Models\MaintenanceControl;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    public function __construct(
        protected VehicleRepositoryInterface $vehicleRepository,        
        protected MaintenanceRepositoryInterface $maintenanceRepository,
        protected FuelSupplierRepositoryInterface $fuelSupplierRepository
    )
    {
    }
    public function getDashboardData(): DashboardResponseDTO
    {
        $vehicleCount = $this->vehicleRepository->count();
        $nextMaintenances = $this->maintenanceRepository->nextMaintenances();
        $lastsFuelSuppliers = $this->fuelSupplierRepository->lastsFuelSuppliers();
        $mediaConsumption = $this->fuelSupplierRepository->totalFuelSuppliersByMonth();
        $totalCost = $this->fuelSupplierRepository->totalFuelSuppliersByMonth();
        $totalMaintenances = $this->maintenanceRepository->totalMaintenancesByMonth();
        return new DashboardResponseDTO(
            vehicleCount: $vehicleCount,
            mediaConsumption: $mediaConsumption,
            totalCost: $totalCost+$totalMaintenances,
            recentFuelSupplies: $this->convertToFuelSupplierResponseDTO($lastsFuelSuppliers),
            recentMaintenances: $this->convertToMaintenanceResponseDTO($nextMaintenances),
            
        );
    }

    private function convertToFuelSupplierResponseDTO(Collection $fuelSupplier): array
    {
        return $fuelSupplier->map(fn(FuelSupplier $fuelSupplier) => FuelSupplierResponseDTO::fromEntity($fuelSupplier))->toArray();
    
    }
    private function convertToMaintenanceResponseDTO(Collection $maintenances): array
    {
        return $maintenances->map(fn(MaintenanceControl $maintenance) => MaintenanceResponseDTO::fromEntity($maintenance))->toArray();
    }
}