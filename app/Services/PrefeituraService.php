<?php

namespace App\Services;

use App\DTOs\CreatePrefeituraDTO;
use App\Models\Prefeitura;

class PrefeituraService
{
    public function createPrefeitura(CreatePrefeituraDTO $dto): Prefeitura
    {
        return Prefeitura::create($dto->toArray());
    }

    public function updatePrefeitura(CreatePrefeituraDTO $dto, int $id): Prefeitura
    {
        return Prefeitura::find($id)->update($dto->toArray());
    }

    public function deletePrefeitura(int $id): void
    {
        Prefeitura::find($id)->delete();
    }

    public function getPrefeituraById(int $id): Prefeitura
    {
        return Prefeitura::find($id);
    }
}