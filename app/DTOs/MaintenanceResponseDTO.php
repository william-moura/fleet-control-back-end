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
        public array $services,
        public int $supplier_id,        
        public float $maintenanceKilometers,
        public VehicleResponseDTO $vehicle,
        public SupplierResponseDTO $supplier,
        public string $maintenanceDate,
        public float $maintenanceCost,
        public string $maintenanceNotes,
        public string $maintenanceNextDate,
        public string $maintenanceStatus,
        public string $maintenancePreviousDateFinished,
    ) {}
    public static function fromEntity(MaintenanceControl $maintenance): self
    {
        return new self(
            id: $maintenance->id,
            vehicle_id: $maintenance->vehicle_id,
            services: $maintenance->maintenanceRelationServices
            ->map(fn(MaintenanceRelationService $service) => MaintenanceServiceResponseDTO::fromEntity($service->maintenanceService))->toArray(),
            supplier_id: $maintenance->supplier_id,            
            maintenanceKilometers: $maintenance->maintenance_control_kilometers,
            vehicle: VehicleResponseDTO::fromEntity($maintenance->vehicle),
            supplier: SupplierResponseDTO::fromEntity($maintenance->supplier),
            maintenanceDate: $maintenance->maintenance_control_date,
            maintenanceCost: $maintenance->maintenance_control_total_cost,
            maintenanceNotes: $maintenance->maintenance_control_notes,
            maintenanceNextDate: $maintenance->maintenance_control_next_date,
            maintenanceStatus: $maintenance->maintenance_control_status,
            maintenancePreviousDateFinished: $maintenance->maintenance_control_previous_date_finished,
        );
    }
}