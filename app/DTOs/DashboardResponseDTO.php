<?php

namespace App\DTOs;

use App\Models\FuelSupplier;
use App\Models\MaintenanceControl;
use App\DTOs\FuelSupplierResponseDTO;
use App\DTOs\MaintenanceResponseDTO;
class DashboardResponseDTO
{
    public function __construct(
        public int $vehicleCount,
        public float $mediaConsumption,
        public float $totalCost,
        public array $recentFuelSupplies,
        public array $recentMaintenances,
        public array $evolutionExpenses
    ) { }
    public function toArray(): array
    {
        return [
            'vehicleCount' => $this->vehicleCount,
            'mediaConsumption' => $this->mediaConsumption,
            'totalCost' => $this->totalCost,
            'fuelSupplier' => array_map(fn(FuelSupplier $fuelSupplier) => FuelSupplierResponseDTO::fromEntity($fuelSupplier), $this->fuelSupplier),
            'maintenance' => array_map(fn(MaintenanceControl $maintenance) => MaintenanceResponseDTO::fromEntity($maintenance), $this->maintenance),
            'evolutionExpenses' => $this->evolutionExpenses,
        ];
    }
}