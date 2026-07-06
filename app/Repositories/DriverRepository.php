<?php

namespace App\Repositories;

use App\DTOs\CreateDriverDTO;
use App\Models\Driver;
use App\Repositories\Contracts\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DriverRepository implements DriverRepositoryInterface
{
    public function __construct(private Driver $model){}
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
            return $query->where('driver_name', 'like', "%$search%")
                ->orWhere('driver_registered_number', 'like', "%$search%")
                ->orWhere('driver_address', 'like', "%$search%")
                ->orWhere('driver_city', 'like', "%$search%")
                ->orWhere('driver_state', 'like', "%$search%")
                ->orWhere('driver_zip_code', 'like', "%$search%");
        })->when($sort, function($query) use ($sort, $sortDirection){
            return $query->orderBy($sort, $sortDirection);
        })->when($page && $perPage, function($query) use ($page, $perPage){
            return $query->skip(($page - 1) * $perPage)->take($perPage);
        })->paginate($perPage, ['*'], 'page', $page);
    }
    public function createDriver(CreateDriverDTO $dto): Driver
    {
        return $this->model->create([
            'driver_name' => $dto->name,
            'driver_registered_number' => $dto->registeredNumber ?? $this->getNextRegistration(),
            'driver_address' => $dto->address,
            'driver_city' => $dto->city,
            'driver_state' => $dto->state,
            'driver_zip_code' => $dto->zipCode,
            'driver_blood_type' => $dto->bloodType,
            'driver_rg' => $dto->rg,
            'driver_cpf' => $dto->cpf,
            'driver_license_number' => $dto->licenseNumber,
            'driver_license_expiration_date' => $dto->licenseExpirationDate,
            'driver_license_category' => $dto->licenseCategory,
            'driver_birth_date' => $dto->birthDate,
            'driver_phone' => $dto->phone,
            'driver_status' => $dto->status,
            'driver_neighborhood' => $dto->neighborhood,
            'driver_email' => $dto->email,
        ]);
    }
    public function updateDriver(int $id, CreateDriverDTO $dto): Driver
    {
        return $this->model->find($id)->update([
            'driver_name' => $dto->name,
            'driver_registered_number' => $dto->registeredNumber,
            'driver_address' => $dto->address,
            'driver_city' => $dto->city,
            'driver_state' => $dto->state,
            'driver_zip_code' => $dto->zipCode,
            'driver_blood_type' => $dto->bloodType,
            'driver_rg' => $dto->rg,
            'driver_cpf' => $dto->cpf,
            'driver_license_number' => $dto->licenseNumber,
            'driver_license_expiration_date' => $dto->licenseExpirationDate,
            'driver_license_category' => $dto->licenseCategory,
            'driver_birth_date' => $dto->birthDate,
            'driver_phone' => $dto->phone,
            'driver_status' => $dto->status,
            'driver_neighborhood' => $dto->neighborhood,
        ]) ? $this->model->find($id) : null;
    }
    public function destroyDriver(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showDriver(int $id): Driver
    {
        return $this->model->find($id);
    }

    public function getNextRegistration(): int
    {
        return $this->model->max('driver_registered_number') + 1;
    }
}