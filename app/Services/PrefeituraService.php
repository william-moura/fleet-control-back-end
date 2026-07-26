<?php

namespace App\Services;

use App\DTOs\CreatePrefeituraDTO;
use App\DTOs\PrefeituraResponseDTO;
use App\Models\Prefeitura;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getAllPrefeituras(
        int $limit = 10, 
        int $page = 1, 
        string $search = '', 
        string $sort = 'created_at', 
        string $sortDirection = 'desc'
    ): LengthAwarePaginator
    {
        $prefeituras = Prefeitura::when($search, function ($query) use ($search) {
            $query->where('prefeitura_name', 'like', '%' . $search . '%');
        })
        ->orderBy($sort, $sortDirection)
        ->paginate($limit, ['*'], 'page', $page);
        return $prefeituras->through(fn(Prefeitura $prefeitura) => PrefeituraResponseDTO::fromEntity($prefeitura));
    }

    public function getNextRegistration(): int
    {
        return Prefeitura::max('id') + 1;
    }
}