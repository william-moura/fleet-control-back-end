<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\Request;

class DestroyVehicleController extends Controller
{
    public function __invoke($id, VehicleService $service)
    {
        try {
            $service->destroyVehicle($id);
            return response()->json(['message' => 'Vehicle deleted successfully'], 204);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
