<?php

namespace App\Repositories;

use App\DTOs\CreateMaintenanceControlDTO;
use App\Models\MaintenanceControl;
use App\Repositories\Contracts\MaintenanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    public function __construct(private MaintenanceControl $model){}
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        return $this->model->query()
        ->when($search, function($query) use ($search){
            return $query->where('maintenance_control_name', 'like', "%$search%")
                ->orWhere('maintenance_control_description', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createMaintenance(CreateMaintenanceControlDTO $dto): MaintenanceControl
    {
        return DB::transaction(function () use ($dto) {
            $maintenance = $this->model->create($dto->toArray());
            $maintenance->maintenanceRelationServices()->createMany($dto->toMaintenanceServicesArray());
            return $maintenance->load('maintenanceRelationServices');
        });
    }
    public function updateMaintenance(int $id, CreateMaintenanceControlDTO $dto): MaintenanceControl
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyMaintenance(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showMaintenance(int $id): MaintenanceControl
    {
        return $this->model->with('maintenanceRelationServices')->find($id);
    }

    public function nextMaintenances(): Collection
    {
        return $this->model
            ->query()
            ->where('maintenance_control_next_date', '>=', now())
            ->orderBy('maintenance_control_next_date', 'asc')
            ->take(5)
            ->get();
    }
    public function totalMaintenancesByMonth(): float
    {
        return $this->model->whereMonth('maintenance_control_date', now()->month)->sum('maintenance_control_total_cost');
    }

    /**
 * Busca manutenções próximas do vencimento por KM ou Data.
 *
 * @param int $kmThreshold Margem de antecedência em quilômetros.
 * @param int $daysThreshold Margem de antecedência em dias.
 * @return \Illuminate\Support\Collection
 */
public function findUpcomingMaintenances(int $kmThreshold = 500, int $daysThreshold = 7): Collection
{
    // Subquery para obter a última quilometragem registrada de cada veículo
    // Usamos DB::table para evitar o overhead de instanciar Models na subquery
    $latestKilometers = DB::table('kilometers')
        ->select('vehicle_id')
        ->selectRaw('MAX(kilometers_value) as km_atual')
        ->groupBy('vehicle_id');

    return $this->model
        ->newQuery()
        ->with(['vehicle','supplier', 'vehicle.maxKilometer', 'vehicle.drivers', 'vehicle.fines', 'vehicle.maintenances', 'vehicle.fuelSuppliers'])
        ->select([
            'vehicles.vehicle_plate',
            'maintenance_control.maintenance_control_description',
            'maintenance_control.maintenance_control_next_kilometers',
            'maintenance_control.maintenance_control_next_date',
            'maintenance_control.maintenance_control_total_cost',
            'maintenance_control.maintenance_control_kilometers',
            'maintenance_control.maintenance_control_description',
            'maintenance_control.maintenance_control_date',
            'maintenance_control.maintenance_control_notes',
            'maintenance_control.maintenance_control_status',
            'maintenance_control.maintenance_control_previous_date_finished',
            'ul.km_atual',
            'maintenance_control.supplier_id',
            'maintenance_control.vehicle_id',
            'maintenance_control.id'
        ])
        // Alias para facilitar o acesso no Front-end/Resource
        ->selectRaw('(maintenance_control.maintenance_control_next_kilometers - ul.km_atual) AS km_restante')
        ->selectRaw('DATEDIFF(maintenance_control.maintenance_control_next_date, NOW()) AS dias_restantes')
        
        // Join com a tabela de veículos para pegar a placa
        ->join('vehicles', 'maintenance_control.vehicle_id', '=', 'vehicles.id')
        
        // Join com a subquery de quilometragem (ul = última leitura)
        ->joinSub($latestKilometers, 'ul', function ($join) {
            $join->on('maintenance_control.vehicle_id', '=', 'ul.vehicle_id');
        })
        
        // Filtros de negócio
        ->where('maintenance_control.maintenance_control_status', 1)
        ->where(function ($query) use ($kmThreshold, $daysThreshold) {
            $query->whereRaw('ul.km_atual >= (maintenance_control.maintenance_control_next_kilometers - ?)', [$kmThreshold])
                  ->orWhereRaw('maintenance_control.maintenance_control_next_date <= DATE_ADD(NOW(), INTERVAL ? DAY)', [$daysThreshold]);
        })
        
        // Ordenação: primeiro o que está mais crítico (menor km restante/dias)
        ->orderBy('km_restante', 'asc')
        ->orderBy('dias_restantes', 'asc')
        ->get();
    }
    public function getMaintenanceControlsByVehicle(int $id): Collection
    {
        return $this->model->with(['vehicle', 'supplier', 'vehicle.maxKilometer', 'vehicle.drivers', 'vehicle.fines', 'vehicle.maintenances', 'vehicle.fuelSuppliers'])
        ->where('vehicle_id', $id)
        ->orderBy('maintenance_control_date', 'desc')
        ->get();
    }
}