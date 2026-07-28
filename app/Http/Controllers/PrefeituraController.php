<?php

namespace App\Http\Controllers;

use App\DTOs\CreatePrefeituraDTO;
use App\Http\Requests\CreatePrefeituraRequest;
use App\Services\PrefeituraService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrefeituraController extends Controller
{    

    public function __construct(private PrefeituraService $prefeituraService)
    {
        $this->prefeituraService = $prefeituraService;
    }

    public function store(CreatePrefeituraRequest $request): JsonResponse
    {
        return response()->json($this->prefeituraService->createPrefeitura(CreatePrefeituraDTO::fromRequest($request)), 201);
    }

    public function update(CreatePrefeituraRequest $request, int $id)
    {
        return response()->json($this->prefeituraService->updatePrefeitura(CreatePrefeituraDTO::fromRequest($request), $id));
    }

    public function destroy(int $id)
    {
        return $this->prefeituraService->deletePrefeitura($id);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->prefeituraService->getPrefeituraById($id));
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        return $this->prefeituraService->getAllPrefeituras($limit, $page, $search, $sort, $sortDirection);
    }

    public function getNextRegistration()
    {
        return $this->prefeituraService->getNextRegistration();
    }

    public function uploadPhotos(Request $request)
    {
        return $this->prefeituraService->uploadPhotos($request);
    }
}
