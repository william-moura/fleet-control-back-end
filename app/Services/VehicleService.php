<?php

namespace App\Services;

use App\DTOs\CreateKilometerDTO;
use App\DTOs\CreateVehicleDTO;
use App\DTOs\HistoryResponseDTO;
use App\DTOs\KilometerResponseDTO;
use App\DTOs\VehicleResponseDTO;
use App\Exceptions\RuleAssociationException;
use App\Models\Driver;
use App\Models\Kilometer;
use App\Models\Media;
use App\Models\Vehicle;
use App\Repositories\Contracts\KilometerRepositoryInterface;
use App\Repositories\Contracts\VehicleRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use function Illuminate\Support\weeks;

class VehicleService
{
    public function __construct(protected VehicleRepositoryInterface $vehicleRepository, protected KilometerRepositoryInterface $kilometerRepository){}
    public function createVehicle(CreateVehicleDTO $dto): Vehicle
    {
        $existingVehicle = $this->vehicleRepository->getVehicleByPlate($dto->vehiclePlate);
        if ($existingVehicle) {
            throw new HttpResponseException(response()->json(['message' => 'Veículo com placa '.$dto->vehiclePlate.' já cadastrado'], 422));
        }
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
        /*
          
        $vehicles = Cache::remember('active_vehicles_'.md5($search.$sort.$sortDirection.$page.$perPage), weeks(1), function () use ($search, $sort, $sortDirection, $page, $perPage) {
        });
        */
        $vehicles =  $this->vehicleRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $vehicles->through(fn(Vehicle $vehicle) => VehicleResponseDTO::fromEntity($vehicle));
    }
    public function destroyVehicle(int $id): void
    {        
        $vehicle = $this->vehicleRepository->showVehicle($id);
        if ($vehicle->drivers) {
            throw new RuleAssociationException('Veículo possui motoristas cadastrados', 422);
        }
        if ($vehicle->fines) {
            throw new RuleAssociationException('Veículo possui multas cadastradas', 422);
        }
        if ($vehicle->kilometers) {
            throw new RuleAssociationException('Veículo possisi quilometragem cadastrada', 422);
        }
        if ($vehicle->fuelSuppliers) {
            throw new RuleAssociationException('Veículo possui abastecimentos cadastrados', 422);
        }

        if ($vehicle->maintenances) {
            throw new RuleAssociationException('Veículo possui manutenções cadastradas', 422);
        }        
        
        DB::transaction(function () use ($id) {
            $this->vehicleRepository->destroyVehicle($id);
        });
        Cache::flush();
    }

    public function showVehicle(int $id): VehicleResponseDTO
    {
        $vehicle = $this->vehicleRepository->showVehicle($id);
        //dd($vehicle)
        return VehicleResponseDTO::fromEntity($vehicle);
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
        $vehicle->drivers()->sync($driversId);
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
        return Driver::query()
            ->join('vehicle_relationship_drivers', 'drivers.id', '=', 'vehicle_relationship_drivers.driver_id')
            ->where('vehicle_relationship_drivers.vehicle_id', $vehicleId)
            ->where('drivers.driver_status', 1)
            ->whereNull('drivers.deleted_at')
            ->groupBy('drivers.id')
            ->select('drivers.id', 'drivers.driver_name', 'drivers.driver_cpf', 'drivers.driver_phone', 'drivers.driver_address', 'drivers.driver_city', 
            'drivers.driver_state', 'drivers.driver_zip_code')
            ->get();        
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
    public function showKilometer(int $id): KilometerResponseDTO
    {
        $kilometer = $this->kilometerRepository->showKilometer($id);
        return KilometerResponseDTO::fromEntity($kilometer);
    }
    public function updateKilometer(int $id, CreateKilometerDTO $dto): KilometerResponseDTO
    {
        $kilometer = $this->kilometerRepository->updateKilometer($id, $dto);
        return KilometerResponseDTO::fromEntity($kilometer);
    }
    public function destroyKilometer(int $id): void
    {
        $this->kilometerRepository->destroyKilometer($id);
    }
    public function addSyncDriver(int $vehicleId, int $driversId): void
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->drivers()->attach($driversId);
        Cache::flush();
    }
}