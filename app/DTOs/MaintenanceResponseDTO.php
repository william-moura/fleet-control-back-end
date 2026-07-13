<?php

namespace App\DTOs;

use App\Models\MaintenanceControl;
use App\Models\MaintenanceRelationService;
use App\DTOs\MaintenanceServiceResponseDTO;
use Illuminate\Support\Carbon;
class MaintenanceResponseDTO
{
    public function __construct(
        public int $id,
        public int $vehicleId,
        public array $services,
        public int $supplierId,        
        public float $maintenanceKilometers,
        public VehicleResponseDTO $vehicle,
        public SupplierResponseDTO $supplier,
        public string $maintenanceDate,
        public float $maintenanceCost,
        public ?string $maintenanceNotes = null,
        public string $maintenanceNextDate,
        public string $maintenanceStatus,
        public string $maintenancePreviousDateFinished,
        public float $maintenanceNextKilometers,
        public string $servicesFormatted
    ) {}
    public static function fromEntity(MaintenanceControl $maintenance): self
    {
        return new self(
            id: $maintenance->id,
            vehicleId: $maintenance->vehicle_id,
            services: $maintenance->maintenanceRelationServices
            ->map(fn(MaintenanceRelationService $service) => MaintenanceServiceResponseDTO::fromEntity($service->maintenanceService))->toArray(),
            supplierId: $maintenance->supplier_id,            
            maintenanceKilometers: $maintenance->maintenance_control_kilometers,
            vehicle: VehicleResponseDTO::fromEntity($maintenance->vehicle, true),
            supplier: SupplierResponseDTO::fromEntity($maintenance->supplier),
            maintenanceDate: Carbon::parse($maintenance->maintenance_control_date)->format('Y-m-d'),
            maintenanceCost: $maintenance->maintenance_control_total_cost,
            maintenanceNotes: $maintenance->maintenance_control_notes ?? null,
            maintenanceNextDate: Carbon::parse($maintenance->maintenance_control_next_date)->format('Y-m-d'),
            maintenanceStatus: $maintenance->maintenance_control_status,
            maintenancePreviousDateFinished: Carbon::parse($maintenance->maintenance_control_previous_date_finished)->format('Y-m-d'),
            maintenanceNextKilometers: $maintenance->maintenance_control_next_kilometers ?? 0,
            servicesFormatted: $maintenance->maintenanceRelationServices
            ->map(fn(MaintenanceRelationService $service) => $service->maintenanceService->maintenance_control_service_name)
            ->implode(', ')
        );
    }
}