<?php

namespace App\DTOs;

class DashboardResponseDTO
{
    public function __construct(
        public int $vehicleCount,
        public float $mediaConsumption,
        public float $totalCost,
        public FuelSupplierResponseDTO $fuelSupplier,
        public MaintenanceResponseDTO $maintenance,
    ) {}
}