<?php

namespace App\Services;

use App\DTOs\CreateKilometerDTO;
use App\DTOs\CreateVehicleDTO;
use App\DTOs\HistoryResponseDTO;
use App\DTOs\KilometerResponseDTO;
use App\DTOs\VehicleResponseDTO;
use App\Models\Kilometer;
use App\Models\Media;
use App\Models\Vehicle;
use App\Repositories\Contracts\KilometerRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use function Illuminate\Support\weeks;

class VehicleService
{
    public function __construct(protected VehicleRepositoryInterface $vehicleRepository, protected KilometerRepositoryInterface $kilometerRepository){}
    public function createVehicle(CreateVehicleDTO $dto): Vehicle
    {
        return DB::transaction(function () use ($dto) {
            $veiculo = $this->vehicleRepository->createVehicle($dto);
            if (!empty($dto->photosIds)) {
                $medias =Media::whereIn('id', $dto->photosIds)->get();
                $veiculo->media()->saveMany($medias);
            }
            Cache::flush();
            return $veiculo;
        });
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $vehicles = Cache::remember('active_vehicles_'.md5($search.$sort.$sortDirection.$page.$perPage), weeks(1), function () use ($search, $sort, $sortDirection, $page, $perPage) {
            return $this->vehicleRepository->index($search, $sort, $sortDirection, $page, $perPage);
        });        
        return $vehicles->through(fn(Vehicle $vehicle) => VehicleResponseDTO::fromEntity($vehicle));
    }
    public function destroyVehicle(int $id): void
    {        
        if ($this->vehicleRepository->checkVechicleHasRelationship($id)) {
            throw new \Exception('Veículo não pode ser deletado porque tem relacionamentos com manutenções ou abastecimentos');
        }
        DB::transaction(function () use ($id) {
            $this->vehicleRepository->destroyVehicle($id);
        });
        Cache::flush();
    }

    public function showVehicle(int $id): Vehicle
    {
        return $this->vehicleRepository->showVehicle($id);
    }

    /**
     * Summary of updateVehicle
     * @param mixed $id
     * @param CreateVehicleDTO $dto
     * @return Collection<int, Vehicle>|Vehicle|\stdClass
     */
    public function updateVehicle($id, CreateVehicleDTO $dto): Vehicle
    {
        return DB::transaction(function () use ($id, $dto) {
            $vehicle = $this->vehicleRepository->updateVehicle($id, $dto);
            if (!empty($dto->photosIds)) {
                $medias = Media::whereIn('id', $dto->photosIds)->get();
                $vehicle->media()->saveMany($medias);
            }
            Cache::flush();
            return $vehicle;
        });
    }

    public function syncDriver(int $vehicleId, array $driversId): void
    {
        $vehicle = Vehicle::findOrFail($vehicleId);        
        $vehicle->drivers()->attach($driversId);
        Cache::flush();
    }
    public function detachDriver(int $vehicleId, array $driversId): void
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->drivers()->detach($driversId);
        Cache::flush();
    }
    public function showSyncedDrivers(int $vehicleId): Collection
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        return $vehicle->drivers;
    }
    public function storeKilometer(CreateKilometerDTO $dto): KilometerResponseDTO
    {
        return DB::transaction(function () use ($dto) {
            $kilometer = $this->kilometerRepository->storeKilometer($dto);
            return KilometerResponseDTO::fromEntity($kilometer);
        });
    }
    public function getHistory(int $vehicleId): array
    {
        $maintenanceControls = DB::table('maintenance_control')
            ->where('vehicle_id', $vehicleId)
            ->select('id',
                'maintenance_control_date as date',                
                'maintenance_control_total_cost as totalCost',
                DB::raw("'Manutenção' as type"),
                DB::raw("maintenance_control_description as description"),
            )
            ;
        $fuelSuppliers = DB::table('fuel_suppliers')
            ->where('vehicle_id', $vehicleId)
            ->select('id',
                'fuel_supplier_date as date',
                'fuel_supplier_total as totalCost',
                DB::raw("'Abastecimento' as type"),
                DB::raw("CONCAT('Abastecimento de ', fuel_supplier_quantity, ' litros') as description"),
            )
            ->union($maintenanceControls)
            ->orderBy('date', 'desc')
            ->get();
        return $fuelSuppliers->map(fn(object $item) => HistoryResponseDTO::fromEntity($item))->toArray();
    }
    public function indexKilometers(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $kilometers = $this->kilometerRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $kilometers->through(fn(Kilometer $kilometer) => KilometerResponseDTO::fromEntity($kilometer));
    }
}