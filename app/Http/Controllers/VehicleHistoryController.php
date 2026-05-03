<?php

namespace App\Http\Controllers;

use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleHistoryController extends Controller
{
    public function __invoke(int $id, VehicleService $service): JsonResponse
    {
        $history = $service->getHistory($id);
        return response()->json(
            $history,
            200
        );
    }
}
