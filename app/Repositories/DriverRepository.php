<?php

namespace App\Repositories;

use App\DTOs\CreateDriverDTO;
use App\Models\Driver;
use App\Repositories\Contracts\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DriverRepository implements DriverRepositoryInterface
{
    public function __construct(private Driver $model){}
    public function index(): Collection
    {
        return $this->model->all();
    }
    public function createDriver(CreateDriverDTO $dto): Driver
    {
        return $this->model->create([
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
            'driver_status' => $dto->status
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
}