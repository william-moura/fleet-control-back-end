<?php

namespace App\Services;

use App\DTOs\CreateOrgaoDTO;
use App\Models\Orgao;
use Illuminate\Database\Eloquent\Collection;

class OrgaoService
{
    public function getAllOrgaos(): Collection
    {
        return Orgao::all();
    }

    public function createOrgao(CreateOrgaoDTO $dto): Orgao
    {
        return Orgao::create($dto->toArray());
    }

    public function getOrgaoById(int $id): Orgao
    {
        return Orgao::findOrFail($id);
    }

    public function updateOrgao(CreateOrgaoDTO $dto, int $id): Orgao
    {
        $orgao = Orgao::findOrFail($id);
        $orgao->update($dto->toArray());

        return $orgao->fresh();
    }

    public function deleteOrgao(int $id): void
    {
        Orgao::findOrFail($id)->delete();
    }
}
