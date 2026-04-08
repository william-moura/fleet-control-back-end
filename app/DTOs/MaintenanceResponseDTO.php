<?php

namespace App\DTOs;

use App\Models\MaintenanceControl;
use App\Models\MaintenanceRelationService;

class MaintenanceResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicle_id,
        public array $maintenance_services,
        public int $supplier_id,
        public string $maintenance_control_date,
        public float $maintenance_control_kilometers,
    ) {}
    public static function fromEntity(MaintenanceControl $maintenance): self
    {
        return new self(
            id: $maintenance->id,
            vehicle_id: $maintenance->vehicle_id,
            maintenance_services: $maintenance->maintenanceRelationServices
            ->map(fn(MaintenanceRelationService $service) => $service->maintenanceService->maintenance_control_service_name),
            supplier_id: $maintenance->supplier_id,
            maintenance_control_date: $maintenance->maintenance_control_date,
            maintenance_control_kilometers: $maintenance->maintenance_control_kilometers,
        );
    }
}