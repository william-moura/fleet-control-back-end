<?php

namespace App\Services;

use App\Repositories\Contracts\FuelTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FuelTypeService
{
    public function __construct(protected FuelTypeRepositoryInterface $fuelTypeRepository)
    {
    }
    public function index(): Collection
    {
        return $this->fuelTypeRepository->index();
    }
}