<?php

namespace App\Services;

use App\DTOs\CreateDriverDTO;
use App\DTOs\DriverResponseDTO;
use App\DTOs\UpdateDriverDTO;
use App\Models\Driver;
use App\Models\Media;
use App\Repositories\Contracts\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DriverService
{
    public function __construct(protected DriverRepositoryInterface $driverRepository)
    {
    }
    public function index(
        ?string $search = null,
        ?string $sort = null,
        ?string $sortDirection = null,
        ?int $page = 1,
        ?int $perPage = 5
    ): LengthAwarePaginator
    {
        $drivers = $this->driverRepository->index($search, $sort, $sortDirection, $page, $perPage);
        return $drivers->through(fn(Driver $driver) => DriverResponseDTO::fromEntity($driver));

    }
    public function createDriver(CreateDriverDTO $dto): Driver
    {
        $existeDriver = $this->driverRepository->getDriverByCpf($dto->cpf);
        if ($existeDriver) {            
            throw new HttpResponseException(response()->json(['message' => 'Cpf já cadastrado'], 422));
        }
        return DB::transaction(function () use ($dto) {
            $driver = $this->driverRepository->createDriver($dto);
            if (!empty($dto->photosIds)) {
                $medias =Media::whereIn('id', $dto->photosIds)->get();
                $driver->media()->saveMany($medias);
            }            
            return $driver;
        });
    }
    public function updateDriver(int $id, UpdateDriverDTO $dto): Driver
    {
        return DB::transaction(function () use ($id, $dto) {
            $driver = $this->driverRepository->updateDriver($id, $dto);
            if (!empty($dto->photosIds)) {
                $medias =Media::whereIn('id', $dto->photosIds)->get();
                $driver->media()->saveMany($medias);
            }
            return $driver;
        });
    }
    public function destroyDriver(int $id): void
    {
        $driver = $this->driverRepository->showDriver($id);
        if ($driver->vehicles) {
            throw new HttpResponseException(response()->json(['message' => 'Motorista possui veículo cadastrado'], 422));
        }
        if ($driver->vehicleFines) {
            throw new HttpResponseException(response()->json(['message' => 'Motorista possui multas cadastradas'], 422));
        }
        if ($driver->kilometers) {
            throw new HttpResponseException(response()->json(['message' => 'Motorista possui quilometragem cadastrada'], 422));
        }
        if ($driver->fuelSupplies) {
            throw new HttpResponseException(response()->json(['message' => 'Motorista possui abastecimentos cadastrados'], 422));
        }

        $this->driverRepository->destroyDriver($id);
    }
    public function showDriver(int $id): Driver
    {
        return $this->driverRepository->showDriver($id);
    }
    public function getNextRegistration(): string
    {
        $registration = $this->driverRepository->getNextRegistration();
        return str_pad($registration, 4, '0', STR_PAD_LEFT);
    }
}