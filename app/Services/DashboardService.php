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
        $maintenanceCount = $this->maintenanceRepository->nextMaintenances();
        $fuelSupplierCount = $this->fuelSupplierRepository->lastsFuelSuppliers();
        return new DashboardResponseDTO(
            vehicleCount: $vehicleCount,
            mediaConsumption: 10,
            totalCost: 1000,
            fuelSupplier: $this->convertToFuelSupplierResponseDTO($fuelSupplierCount),
            maintenance: $this->convertToMaintenanceResponseDTO($maintenanceCount),
            
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