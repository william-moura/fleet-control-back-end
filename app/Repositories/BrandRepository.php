<?php

namespace App\Repositories;

use App\DTOs\CreateBrandDTO;
use App\Models\VehicleBrand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository implements BrandRepositoryInterface
{
    public function __construct(private VehicleBrand $model){}
    public function index(): Collection
    {
        return $this->model->all();
    }
    public function createBrand(CreateBrandDTO $dto): VehicleBrand
    {
        return $this->model->create($dto->toArray());
    }
    public function showBrand(int $id): VehicleBrand
    {
        return $this->model->find($id);
    }
    public function updateBrand(int $id, CreateBrandDTO $dto): ?VehicleBrand
    {
        return $this->model->find($id)->update($dto->toArray()) ? $this->model->find($id) : null;
    }
    public function destroyBrand(int $id): void
    {
        $this->model->find($id)->delete();
    }
}