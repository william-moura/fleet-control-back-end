<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{
    public function index(): Collection;
}