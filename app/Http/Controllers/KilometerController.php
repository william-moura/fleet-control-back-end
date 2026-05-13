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
}
