<?php

namespace App\Services;

use App\DTOs\DashboardResponseDTO;
use App\DTOs\FuelSupplierResponseDTO;
use App\DTOs\MaintenanceResponseDTO;
use App\Models\FuelSupplier;
use App\Models\MaintenanceControl;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use App\Repositories\Contracts\VehicleFineRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function __construct(
        protected VehicleRepositoryInterface $vehicleRepository,        
        protected MaintenanceRepositoryInterface $maintenanceRepository,
        protected FuelSupplierRepositoryInterface $fuelSupplierRepository,
        protected VehicleFineRepositoryInterface $vehicleFineRepository
    )
    {
    }
    public function getDashboardData(): DashboardResponseDTO
    {
        $vehicleCount = $this->vehicleRepository->count();
        $nextMaintenances = $this->maintenanceRepository->findUpcomingMaintenances();
        $lastsFuelSuppliers = $this->fuelSupplierRepository->lastsFuelSuppliers();
        $mediaConsumption = $this->fuelSupplierRepository->totalFuelSuppliersByMonth();
        $totalCost = $this->fuelSupplierRepository->totalFuelSuppliersByMonth();
        $totalMaintenances = $this->maintenanceRepository->totalMaintenancesByMonth();
        $evolutionExpenses = $this->getEvolutionExpenses();
        $finesCost = $this->vehicleFineRepository->totalFinesByMonth();
        return new DashboardResponseDTO(
            vehicleCount: $vehicleCount,
            mediaConsumption: $mediaConsumption,
            totalCost: $totalCost+$totalMaintenances+$finesCost,
            recentFuelSupplies: $this->convertToFuelSupplierResponseDTO($lastsFuelSuppliers),
            recentMaintenances: $this->convertToMaintenanceResponseDTO($nextMaintenances),
            evolutionExpenses: $evolutionExpenses,
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

    private function getEvolutionExpenses(): array
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $fuel = DB::table('fuel_suppliers')
        ->whereYear('fuel_supplier_date', $currentYear)
        ->selectRaw('MONTH(fuel_supplier_date) as month, SUM(fuel_supplier_total) as total_cost')
        ->groupBy('month');
        $maintenance = DB::table('maintenance_control')
        ->whereYear('maintenance_control_date', $currentYear)
        ->selectRaw('MONTH(maintenance_control_date) as month, SUM(maintenance_control_total_cost) as total_cost')
        ->groupBy('month')
        ;

        $result = $fuel->unionAll($maintenance)->get();
        $labels = [];
        $values = [];

        foreach (range(1, $currentMonth) as $monthNumber) {
            // Nome do mês curto (Jan, Fev, Mar...) traduzido conforme o locale do Laravel
            $labels[] = Carbon::create()->month($monthNumber)->locale('pt-BR')->translatedFormat('M');
            
            // Soma os valores que pertencem a este mês no resultado do banco
            $values[] = $result->where('month', $monthNumber)->sum('total_cost');
        }
        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}