<?php

namespace App\Repositories;

use App\DTOs\CreateSupplierDTO;
use App\Models\Supplier;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function __construct(private Supplier $model){}
    public function index(): Collection
    {
        return $this->model->all();
    }
    public function createSupplier(CreateSupplierDTO $dto): Supplier
    {
        return $this->model->create($dto->toArray());
    }
    public function updateSupplier(int $id, CreateSupplierDTO $dto): Supplier
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroySupplier(int $id): void
    {
        $this->model->find($id)->delete();
    }
    public function showSupplier(int $id): Supplier
    {
        return $this->model->find($id);
    }
}