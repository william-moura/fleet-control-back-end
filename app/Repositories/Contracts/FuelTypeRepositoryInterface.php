<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface FuelTypeRepositoryInterface
{
    public function index(): Collection;
}