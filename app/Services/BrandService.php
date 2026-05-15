<?php

namespace App\Services;

use App\DTOs\BrandResponseDTO;
use App\DTOs\CreateBrandDTO;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use function Illuminate\Support\weeks;

class BrandService
{
    public function __construct(protected BrandRepositoryInterface $brandRepository)
    {
    }
    public function index(): Collection
    {
        $brands = Cache::remember('brands', weeks(1), function () {
            return $this->brandRepository->index();
        });
        return $brands;
    }
    public function createBrand(CreateBrandDTO $dto): BrandResponseDTO
    {
        $brand = $this->brandRepository->createBrand($dto);
        Cache::forget('brands');
        return BrandResponseDTO::fromEntity($brand);
    }

    public function showBrand(int $id): BrandResponseDTO
    {
        $brand = $this->brandRepository->showBrand($id);
        return BrandResponseDTO::fromEntity($brand);
    }

    public function updateBrand(int $id, CreateBrandDTO $dto): BrandResponseDTO
    {
        $brand = $this->brandRepository->updateBrand($id, $dto);
        Cache::forget('brands');
        return BrandResponseDTO::fromEntity($brand);
    }

    public function destroyBrand(int $id): void
    {
        $this->brandRepository->destroyBrand($id);
        Cache::forget('brands');
    }
}