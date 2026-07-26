<?php

namespace App\Services;

use App\DTOs\CreateSecretariaDTO;
use App\Models\Secretaria;
use Illuminate\Database\Eloquent\Collection;

class SecretariaService
{
    public function getAllSecretarias(): Collection
    {
        return Secretaria::all();
    }

    public function createSecretaria(CreateSecretariaDTO $dto): Secretaria
    {
        return Secretaria::create($dto->toArray());
    }

    public function getSecretariaById(int $id): Secretaria
    {
        return Secretaria::findOrFail($id);
    }

    public function updateSecretaria(CreateSecretariaDTO $dto, int $id): Secretaria
    {
        $secretaria = Secretaria::findOrFail($id);
        $secretaria->update($dto->toArray());

        return $secretaria->fresh();
    }

    public function deleteSecretaria(int $id): void
    {
        Secretaria::findOrFail($id)->delete();
    }
}
