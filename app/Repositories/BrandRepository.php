<?php

namespace App\Repositories;

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
}