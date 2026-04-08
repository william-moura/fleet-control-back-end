<?php

namespace App\DTOs;

use App\Http\Requests\StoreMaintenanceControlRequest;
use Carbon\Carbon;
use DateTimeImmutable;

class CreateMaintenanceControlDTO
{
    public function __construct(
        public int $vehicle_id,
        public array $maintenance_services,
        public int $supplier_id,
        public string $maintenance_control_date,
        public float $maintenance_control_kilometers,
        public string $maintenance_control_description,
        public float $maintenance_control_total_cost,
        public string $maintenance_control_notes,
        public string $maintenance_control_next_date,
        public ?string $maintenance_control_status = null,
        public string $maintenance_control_previous_date_finished,
    ) {}
    public static function fromRequest(StoreMaintenanceControlRequest $request): self
    {
        return new self(
            vehicle_id: $request->input('vehicleId'),
            maintenance_services: $request->input('services') ?? [],
            supplier_id: $request->input('supplierId'),
            maintenance_control_date: Carbon::parse($request->input('maintenanceDate'))->format('Y-m-d'),
            maintenance_control_kilometers: $request->input('maintenanceKilometers'),
            maintenance_control_description: $request->input('maintenanceNotes'),
            maintenance_control_total_cost: $request->input('maintenanceCost'),
            maintenance_control_notes: $request->input('maintenanceNotes'),
            maintenance_control_next_date: Carbon::parse($request->input('nextMaintenanceDate'))->format('Y-m-d'),
            maintenance_control_status: $request->input('status') ? (int) $request->input('status') : 1,
            maintenance_control_previous_date_finished: Carbon::parse($request->input('previsionDateFinish'))->format('Y-m-d'),
        );
    }

    public function toMaintenanceServicesArray(): array
    {
        return array_map(function($service) {
            return [
                'maintenance_service_id' => $service['maintenance_service_id'],
            ];
        }, $this->maintenance_services);
    }
    public function toArray(): array
    {
        return [
            'vehicle_id' => $this->vehicle_id,
            'maintenance_services' => $this->toMaintenanceServicesArray(),
            'supplier_id' => $this->supplier_id,
            'maintenance_control_date' => $this->maintenance_control_date,
            'maintenance_control_kilometers' => $this->maintenance_control_kilometers,
            'maintenance_control_description' => $this->maintenance_control_description,
            'maintenance_control_total_cost' => $this->maintenance_control_total_cost,
            'maintenance_control_notes' => $this->maintenance_control_notes,
            'maintenance_control_next_date' => $this->maintenance_control_next_date,
            'maintenance_control_status' => $this->maintenance_control_status,
            'maintenance_control_previous_date_finished' => $this->maintenance_control_previous_date_finished,
        ];
    }
}