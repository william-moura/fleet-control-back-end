<?php

namespace App\Services;

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
}