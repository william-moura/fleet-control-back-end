<?php

namespace App\DTOs;

use App\Http\Requests\StoreMaintenanceServiceRequest;

class CreateMaintenanceServiceDTO
{
    public function __construct(
        public string $maintenance_control_service_name,
    ) {}
    public static function fromRequest(StoreMaintenanceServiceRequest $request): self
    {
        return new self(
            maintenance_control_service_name: $request->input('maintenance_control_service_name'),
        );
    }
    public function toArray(): array
    {
        return [
            'maintenance_control_service_name' => $this->maintenance_control_service_name,
        ];
    }
}