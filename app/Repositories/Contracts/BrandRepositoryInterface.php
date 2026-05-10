<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateBrandDTO;
use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{
    public function index(): Collection;
    public function createBrand(CreateBrandDTO $dto): VehicleBrand;
    public function showBrand(int $id): VehicleBrand;
    public function updateBrand(int $id, CreateBrandDTO $dto): ?VehicleBrand;
    public function destroyBrand(int $id): void;
}