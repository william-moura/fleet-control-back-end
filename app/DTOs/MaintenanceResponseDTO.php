<?php

namespace App\DTOs;

use App\Models\MaintenanceControl;
use App\Models\MaintenanceRelationService;
use App\DTOs\MaintenanceServiceResponseDTO;
class MaintenanceResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicle_id,
        public array $maintenance_services,
        public int $supplier_id,
        public string $maintenance_control_date,
        public float $maintenance_control_kilometers,
        public VehicleResponseDTO $vehicle,
        public SupplierResponseDTO $supplier,
        public string $maintenanceDate,
        public float $maintenanceCost
    ) {}
    public static function fromEntity(MaintenanceControl $maintenance): self
    {
        return new self(
            id: $maintenance->id,
            vehicle_id: $maintenance->vehicle_id,
            maintenance_services: $maintenance->maintenanceRelationServices
            ->map(fn(MaintenanceRelationService $service) => MaintenanceServiceResponseDTO::fromEntity($service->maintenanceService))->toArray(),
            supplier_id: $maintenance->supplier_id,
            maintenance_control_date: $maintenance->maintenance_control_date,
            maintenance_control_kilometers: $maintenance->maintenance_control_kilometers,
            vehicle: VehicleResponseDTO::fromEntity($maintenance->vehicle),
            supplier: SupplierResponseDTO::fromEntity($maintenance->supplier),
            maintenanceDate: $maintenance->maintenance_control_date,
            maintenanceCost: $maintenance->maintenance_control_total_cost,
        );
    }
}