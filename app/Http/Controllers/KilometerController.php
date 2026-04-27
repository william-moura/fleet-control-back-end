<?php

namespace App\Http\Controllers;

use App\DTOs\CreateKilometerDTO;
use App\Http\Requests\StoreKilometerRequest;
use App\Services\VehicleService;

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
}
