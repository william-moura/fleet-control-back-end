<?php

namespace App\Repositories;

use App\Models\FuelType;
use App\Repositories\Contracts\FuelTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FuelTypeRepository implements FuelTypeRepositoryInterface
{
    public function __construct(private FuelType $model){}
    public function index(): Collection
    {
        return $this->model->all();
    }
}