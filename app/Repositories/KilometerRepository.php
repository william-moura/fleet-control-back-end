<?php

namespace App\Repositories;

use App\DTOs\CreateKilometerDTO;
use App\Models\Kilometer;
use App\Repositories\Contracts\KilometerRepositoryInterface;

class KilometerRepository implements KilometerRepositoryInterface
{
    public function __construct(private Kilometer $model){}
    public function storeKilometer(CreateKilometerDTO $dto): Kilometer
    {
        return $this->model->create($dto->toArray());
    }
}