<?php

namespace App\Http\Controllers;

use App\DTOs\SyncedDriversResponseDTO;
use App\Http\Requests\VehicleSyncDriverRequest;
use App\Models\Driver;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class VechicleSyncDriverController extends Controller
{
    public function __construct(protected VehicleService $vehicleService)
    {
    }
    public function sync(int $id, VehicleSyncDriverRequest $request)
    {
        $driversId = $request->input('driver_id');
        $this->vehicleService->syncDriver($id, $driversId);
        return response()->json(['message' => 'Vehicle and driver synced successfully'], 201);
    }
    public function detach(int $id, VehicleSyncDriverRequest $request)
    {
        $driversId = $request->input('driver_id');
        $this->vehicleService->detachDriver($id, $driversId);
        return response()->json(['message' => 'Vehicle and driver detached successfully'], 204);
    }

    public function showSyncedDrivers(int $vehicleId): JsonResponse
    {
        $drivers = $this->vehicleService->showSyncedDrivers($vehicleId);
        return response()->json(
            $drivers->map(fn(Driver $driver) => SyncedDriversResponseDTO::fromEntity($driver)),
            200
        );
    }
}
