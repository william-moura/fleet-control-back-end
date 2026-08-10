<?php

namespace App\Services;

use App\DTOs\CreateViagemDTO;
use App\DTOs\ViagemResponseDTO;
use App\Models\Viagem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ViagemService
{
    public function index(
        int $limit = 10,
        int $page = 1,
        string $search = '',
        string $sort = 'created_at',
        string $sortDirection = 'desc',
    ): LengthAwarePaginator {
        $viagens = Viagem::with(['vehicle', 'driver'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('viagem_endereco_origem', 'like', '%' . $search . '%')
                        ->orWhere('viagem_endereco_destino', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($sort, $sortDirection)
            ->paginate($limit, ['*'], 'page', $page);

        return $viagens->through(fn (Viagem $viagem) => ViagemResponseDTO::fromEntity($viagem));
    }

    public function createViagem(CreateViagemDTO $dto): ViagemResponseDTO
    {
        return DB::transaction(function () use ($dto) {
            $viagem = Viagem::create($dto->toArray());
            $viagem->load(['vehicle', 'driver']);

            return ViagemResponseDTO::fromEntity($viagem);
        });
    }

    public function getViagemById(int $id): ViagemResponseDTO
    {
        $viagem = Viagem::with(['vehicle', 'driver'])->findOrFail($id);

        return ViagemResponseDTO::fromEntity($viagem);
    }

    public function updateViagem(CreateViagemDTO $dto, int $id): ViagemResponseDTO
    {
        return DB::transaction(function () use ($dto, $id) {
            $viagem = Viagem::findOrFail($id);
            $viagem->update($dto->toArray());
            $viagem->load(['vehicle', 'driver']);

            return ViagemResponseDTO::fromEntity($viagem->fresh(['vehicle', 'driver']));
        });
    }

    public function deleteViagem(int $id): void
    {
        Viagem::findOrFail($id)->delete();
    }
}
