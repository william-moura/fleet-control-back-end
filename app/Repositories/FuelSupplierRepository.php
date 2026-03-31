<?php

namespace App\Repositories;

use App\DTOs\CreateFuelSupplierDTO;
use App\Models\FuelSupplier;
use App\Repositories\Contracts\FuelSupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FuelSupplierRepository implements FuelSupplierRepositoryInterface
{
    public function __construct(private FuelSupplier $model){}
    public function index(): Collection
    {
        return $this->model->all();
    }
    public function createFuelSupplier(CreateFuelSupplierDTO $dto): FuelSupplier
    {
        return $this->model->create($dto->toArray());
    }
    public function updateFuelSupplier(int $id, CreateFuelSupplierDTO $dto): ?FuelSupplier
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyFuelSupplier(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showFuelSupplier(int $id): FuelSupplier
    {
        return $this->model->find($id);
    }
}