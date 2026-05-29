<?php

namespace App\Http\Controllers;

use App\DTOs\CreateKilometerDTO;
use App\Http\Requests\StoreKilometerRequest;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KilometerController extends Controller
{
    private VehicleService $vehicleService;
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }
    public function store(StoreKilometerRequest $request)
    {
        $dto = CreateKilometerDTO::fromRequest($request);
        $kilometer = $this->vehicleService->storeKilometer($dto);
        return response()->json(
            $kilometer,
            201
        );
    }
    public function index(Request $request): JsonResponse
    {
        $kilometers = $this->vehicleService->indexKilometers(
            $request->search??null,
            $request->sort??null,
            $request->sortDirection??null,
            $request->page??1,
            $request->per_page??5
        );
        return response()->json(
            $kilometers,
            200
        );
    }
    public function show(int $id): JsonResponse
    {
        $kilometer = $this->vehicleService->showKilometer($id);
        return response()->json(
            $kilometer,
            200
        );
    }
    public function update(int $id, Request $request): JsonResponse
    {
        $dto = CreateKilometerDTO::fromRequest($request);
        $kilometer = $this->vehicleService->updateKilometer($id, $dto);
        return response()->json(
            $kilometer,
            200
        );
    }
    public function destroy(int $id): JsonResponse
    {
        $this->vehicleService->destroyKilometer($id);
        return response()->json(null, 204);
    }
}
