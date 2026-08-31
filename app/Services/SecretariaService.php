<?php

namespace App\Services;

use App\DTOs\CreateSecretariaDTO;
use App\DTOs\SecretariaResponseDTO;
use App\Models\Secretaria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SecretariaService
{
    public function getAllSecretarias(int $limit, int $page, string $search, string $sort, string $sortDirection): LengthAwarePaginator
    {
        $secreatrias = Secretaria::where('secretaria_name', 'like', "%$search%")
        ->with(['orgao', 'orgao.prefeitura'])
        ->orderBy($sort, $sortDirection)
        ->paginate($limit, ['*'], 'page', $page);
        return $secreatrias->through(fn(Secretaria $secretaria) => SecretariaResponseDTO::fromEntity($secretaria));
    }

    public function createSecretaria(CreateSecretariaDTO $dto): Secretaria
    {
        return Secretaria::create($dto->toArray());
    }

    public function getSecretariaById(int $id): SecretariaResponseDTO
    {
        return SecretariaResponseDTO::fromEntity(Secretaria::findOrFail($id));
    }

    public function updateSecretaria(CreateSecretariaDTO $dto, int $id): Secretaria
    {
        $secretaria = Secretaria::findOrFail($id);
        $secretaria->update($dto->toArray());

        return $secretaria->fresh();
    }

    public function deleteSecretaria(int $id): void
    {
        $secretaria = Secretaria::findOrFail($id);
        if ($secretaria->veiculos->count() > 0) {
            throw new \Exception('Secretaria nao pode ser deletada pois tem orgaos associadas');
        }
        $secretaria->delete();
    }

    public function getNextRegistration(): int
    {
        return Secretaria::max('id') + 1;
    }

    public function getSecretariaByOrgaoId(int $orgaoId): \Illuminate\Support\Collection
    {
        $secretarias = Secretaria::with('orgao', 'orgao.prefeitura')->where('orgao_id', $orgaoId)->get();
        return $secretarias->map(fn(Secretaria $secretaria) => SecretariaResponseDTO::fromEntity($secretaria));
    }
}
