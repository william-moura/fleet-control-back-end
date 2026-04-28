<?php

namespace App\Repositories\Contracts;

use App\DTOs\CreateKilometerDTO;
use App\Models\Kilometer;

interface KilometerRepositoryInterface
{
    public function storeKilometer(CreateKilometerDTO $dto): Kilometer;
}