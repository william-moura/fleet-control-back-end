<?php

namespace App\Services;

use App\DTOs\CreatePrefeituraDTO;
use App\DTOs\PrefeituraResponseDTO;
use App\Models\Media;
use App\Models\Prefeitura;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PrefeituraService
{
    public function createPrefeitura(CreatePrefeituraDTO $dto): PrefeituraResponseDTO
    {
        return DB::transaction(function () use ($dto) {            
            $prefeitura = Prefeitura::create($dto->toArray());
            if ($dto->photoId) {
                $medias =Media::whereIn('id', $dto->photoId)->get();
                $prefeitura->media()->saveMany($medias);
            }
            return PrefeituraResponseDTO::fromEntity($prefeitura);
        });
    }

    public function updatePrefeitura(CreatePrefeituraDTO $dto, int $id): PrefeituraResponseDTO
    {

        // return Prefeitura::find($id)->update($dto->toArray());        
        return DB::transaction(function () use ($id, $dto) {
            $prefeitura = Prefeitura::find($id);
            $prefeitura->update($dto->toArray());
            if ($dto->photoId) {
                $media = Media::find($dto->photoId)->first();
                if ($media) {
                    $prefeitura->media()->save($media);
                }
            }
            return PrefeituraResponseDTO::fromEntity($prefeitura);
        });
    }

    public function deletePrefeitura(int $id): void
    {
        Prefeitura::find($id)->delete();
    }

    public function getPrefeituraById(int $id): PrefeituraResponseDTO
    {
        $prefeitura = Prefeitura::find($id);
        // dd($prefeitura);
        if (!$prefeitura) {
            throw new \Exception('Prefeitura não encontrada');
        }
        return PrefeituraResponseDTO::fromEntity($prefeitura);
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

    public function getOnePrefeitura(): PrefeituraResponseDTO
    {
        $prefeitura = Prefeitura::first();
        if (!$prefeitura) {
            throw new \Exception('Prefeitura não encontrada');
        }
        return PrefeituraResponseDTO::fromEntity($prefeitura);
    }
}