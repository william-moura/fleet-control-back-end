<?php

namespace App\DTOs;

use App\Models\MaintenanceControlService;

class MaintenanceServiceResponseDTO
{
    public function __construct(
        public int $id,
        public string $maintenance_control_service_name,
    ) {}
    public static function fromEntity(MaintenanceControlService $maintenanceService): self
    {
        return new self(
            id: $maintenanceService->id,
            maintenance_control_service_name: $maintenanceService->maintenance_control_service_name,
        );
    }
}