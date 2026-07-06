<?php

namespace App\Services;

use App\DTOs\GenerateReportDTO;
use App\DTOs\ReportResponseDTO;
use App\Exports\BaseExport;
use App\Factories\ReportFactory;
use App\Models\FuelSupplier;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportService
{
    public function generateReport(string $id, GenerateReportDTO $dto): ReportResponseDTO
    {
        $reportStrategy = ReportFactory::make($id);
        $data = $reportStrategy->getDados($dto);        
        $headings = $reportStrategy->getHeadings();
        return new ReportResponseDTO(
            columns: $headings,
            data: $data->toArray(),
            title: $reportStrategy->getTitle(),
        );
    }
    private function selectReportByType(string $id, GenerateReportDTO $dto): Collection
    {
        switch ($id) {
            case 'consumption_by_vehicle':
                return $this->getTotalCostByDateGroupByVehicle($dto->startDate, $dto->endDate);                
            case 'cost':
                return $this->getTotalCostByDateGroupByVehicle($dto->startDate, $dto->endDate);                
            case 'maintenance':
                return $this->getTotalCostByDateGroupByVehicle($dto->startDate, $dto->endDate);
            default:
                throw new \Exception('Report type not found');
        }
    }

    private function getConsuptionByVehicle(
        int $vehicleId, 
        DateTimeImmutable $startDate, 
        DateTimeImmutable $endDate
    ): Collection
    {
        return FuelSupplier::query()
            ->join('vehicles AS v', 'v.id', '=', 'fuel_suppliers.vehicle_id')
            //->where('vehicle_id', $vehicleId)
            ->whereBetween('fuel_supplier_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select([
                'v.id'                
                //'vehicles.vehicle_plate', 
                //'vehicles.vehicle_model'
            ])
            ->selectRaw('CONCAT(v.vehicle_plate, " - ", v.vehicle_model) as veículo')
            ->selectRaw('SUM(fuel_supplier_quantity) as quatidade')
            ->selectRaw('SUM(fuel_suppliers.fuel_supplier_total) as total_cost')
            ->selectRaw('SUM(fuel_supplier_quantity) / SUM(fuel_supplier_total) as consumption')
            ->selectRaw('SUM(fuel_supplier_quantity) / SUM(fuel_supplier_total) * 100 as consumption_percentage')
            ->selectRaw('(MAX(fuel_supplier_kilometers) - MIN(fuel_supplier_kilometers)) / SUM(fuel_supplier_quantity) as consumption_per_liter')
            ->selectRaw('count(fuel_suppliers.id) as total_fuel_suppliers')
            ->groupBy(['v.id'])
            ->get();
    }
    private function getTotalCostByDateGroupByVehicle(DateTimeImmutable $startDate, DateTimeImmutable $endDate): Collection
    {
        return Vehicle::query()
            ->leftJoin('fuel_suppliers', function($join) use ($startDate, $endDate) {
                $join->on('fuel_suppliers.vehicle_id', '=', 'vehicles.id')
                    ->whereBetween('fuel_supplier_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            })
            ->leftJoin('maintenance_control', function($join) use ($startDate, $endDate) {
                $join->on('maintenance_control.vehicle_id', '=', 'vehicles.id')
                    ->whereBetween('maintenance_control_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            })
            ->select(['vehicles.id', 'vehicles.vehicle_plate', 'vehicles.vehicle_model'])
            ->selectRaw('COALESCE(SUM(fuel_suppliers.fuel_supplier_total), 0) + COALESCE(SUM(maintenance_control.maintenance_control_total_cost), 0) as total_cost')
            ->groupBy(['vehicles.id', 'vehicles.vehicle_plate', 'vehicles.vehicle_model'])
            ->get();
    }

    public function generatePdfReport(string $id, GenerateReportDTO $dto): DomPDFPDF
    {
        $reportStrategy = ReportFactory::make($id);
        $data = $reportStrategy->getDados($dto);
        $title = $reportStrategy->getTitle();        
        $headings = $reportStrategy->getHeadings();
        $pdf = Pdf::loadView('reports.basepdf', [
            'data' => $data->toArray(), 
            'title' => $title, 
            'headings' => $headings,
            'startDate' => $dto->startDate->format('d/m/Y'),
            'endDate' => $dto->endDate->format('d/m/Y'),
        ]);
        $pdf->setPaper('a4', 'portrait');
        return $pdf;
    }

    public function generateExcelReport(string $id, GenerateReportDTO $dto): BinaryFileResponse
    {
        $reportStrategy = ReportFactory::make($id);
        $data = $reportStrategy->getDados($dto);
        $title = $reportStrategy->getTitle();        
        $headings = $reportStrategy->getHeadings();
        return Excel::download(new BaseExport($data, $headings), "relatorio_{$id}.xlsx");
    }
}