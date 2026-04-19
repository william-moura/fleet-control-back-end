<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $service): JsonResponse
    {
        return response()->json($service->getDashboardData(), 200);
    }
}
