<?php

namespace App\Services;

use App\DTOs\CreateOrgaoDTO;
use App\DTOs\OrgaoResponseDTO;
use App\Exceptions\RuleAssociationException;
use App\Models\Orgao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrgaoService
{
    public function getAllOrgaos(
        int $limit = 10, 
        int $page = 1, 
        string $search = '', 
        string $sort = 'created_at', 
        string $sortDirection = 'desc'
    ): LengthAwarePaginator
    {
        $orgaos = Orgao::when($search, function ($query) use ($search) {
            $query->where('orgao_name', 'like', '%' . $search . '%');
        })
        ->orderBy($sort, $sortDirection)
        ->paginate($limit, ['*'], 'page', $page);
        return $orgaos->through(fn(Orgao $orgao) => OrgaoResponseDTO::fromEntity($orgao));
    }

    public function createOrgao(CreateOrgaoDTO $dto): OrgaoResponseDTO
    {
        return DB::transaction(function () use ($dto) {            
            $orgao = Orgao::create($dto->toArray());
            return OrgaoResponseDTO::fromEntity($orgao);
        });
    }

    public function getOrgaoById(int $id): OrgaoResponseDTO
    {
        return OrgaoResponseDTO::fromEntity(Orgao::findOrFail($id));
    }

    public function updateOrgao(CreateOrgaoDTO $dto, int $id): Orgao
    {
        $orgao = Orgao::findOrFail($id);
        $orgao->update($dto->toArray());

        return $orgao->fresh();
    }

    public function deleteOrgao(int $id): void
    {
        $orgao = Orgao::findOrFail($id);
        if ($orgao->secretarias->count() > 0) {
            throw new RuleAssociationException('Orgao nao pode ser deletado pois tem secretarias associadas');
        }
        $orgao->delete();
    }

    public function getNextRegistration(): int
    {
        return Orgao::max('id') + 1;
    }

    public function getOrgaosByPrefeitura(int $id): \Illuminate\Support\Collection
    {
        $orgaos = Orgao::where('prefeitura_id', $id)->get();
        return $orgaos->map(fn(Orgao $orgao) => OrgaoResponseDTO::fromEntity($orgao));
    }
}
