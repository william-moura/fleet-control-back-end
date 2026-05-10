<?php

namespace App\Services;

use App\DTOs\BrandResponseDTO;
use App\DTOs\CreateBrandDTO;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    public function __construct(protected BrandRepositoryInterface $brandRepository)
    {
    }
    public function index(): Collection
    {
        return $this->brandRepository->index();
    }
    public function createBrand(CreateBrandDTO $dto): BrandResponseDTO
    {
        $brand = $this->brandRepository->createBrand($dto);
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
        return BrandResponseDTO::fromEntity($brand);
    }

    public function destroyBrand(int $id): void
    {
        $this->brandRepository->destroyBrand($id);
    }
}