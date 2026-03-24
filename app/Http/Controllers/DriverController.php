<?php

namespace App\Http\Controllers;

use App\DTOs\CreateDriverDTO;
use App\DTOs\DriverResponseDTO;
use App\Http\Requests\StoreDriverRequest;
use App\Models\Driver;
use App\Services\DriverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function __construct(protected DriverService $service)
    {
    }
    public function index(): JsonResponse
    {
        $drivers = $this->service->index();
        return response()->json(
            $drivers->map(fn(Driver $driver) => DriverResponseDTO::fromEntity($driver)),
            200
        );
    }
    public function store(StoreDriverRequest $request): JsonResponse
    {
        $dto = CreateDriverDTO::fromRequest($request);
        $driver = $this->service->createDriver($dto);
        return response()->json(
            DriverResponseDTO::fromEntity($driver),
            201
        );
    }
    public function update(StoreDriverRequest $request, $id): JsonResponse
    {
        $dto = CreateDriverDTO::fromRequest($request);
        $driver = $this->service->updateDriver($id, $dto);
        return response()->json(
            DriverResponseDTO::fromEntity($driver),
            200
        );
    }
    public function destroy($id): JsonResponse
    {
        $this->service->destroyDriver($id);
        return response()->json(null, 204);
    }
    public function show($id): JsonResponse
    {
        $driver = $this->service->showDriver($id);
        return response()->json(
            DriverResponseDTO::fromEntity($driver),
            200
        );
    }
}