<?php

namespace App\Http\Controllers;

use App\DTOs\CreateViagemDTO;
use App\Http\Requests\CreateViagemRequest;
use App\Services\ViagemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ViagemController extends Controller
{
    public function __construct(private ViagemService $viagemService)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->viagemService->index(
            limit: $request->integer('limit', 10),
            page: $request->integer('page', 1),
            search: $request->string('search', '')->toString(),
            sort: $request->string('sort', 'created_at')->toString(),
            sortDirection: $request->string('sortDirection', 'desc')->toString(),
        ), 200);
    }

    public function store(CreateViagemRequest $request): JsonResponse
    {
        $viagem = $this->viagemService->createViagem(CreateViagemDTO::fromRequest($request));

        return response()->json($viagem, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->viagemService->getViagemById($id), 200);
    }

    public function update(CreateViagemRequest $request, int $id): JsonResponse
    {
        $viagem = $this->viagemService->updateViagem(CreateViagemDTO::fromRequest($request), $id);

        return response()->json($viagem, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->viagemService->deleteViagem($id);

        return response()->json(null, 204);
    }
}
