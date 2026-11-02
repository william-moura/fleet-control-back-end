<?php

namespace App\Http\Controllers;

use App\DTOs\AlertsSettingDTO;
use App\Http\Requests\AlertSettingsRequest;
use App\Models\AlertsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertSettingsController extends Controller
{
    public function store(AlertSettingsRequest $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->alerts as $alert) {
                AlertsSetting::updateOrCreate(['alert_type' => $alert['alertType']], ['days_before' => $alert['daysBefore']]);
            }
        });

        return response()->json(['message' => 'Alert setting created successfully'], 201);
    }

    public function index()
    {
        $alertSettings = AlertsSetting::all();
        $alertSettingsDTOs = $alertSettings->map(function (AlertsSetting $alertSetting) {
            return AlertsSettingDTO::fromEntity($alertSetting);
        });
        return response()->json([ 'alerts' => $alertSettingsDTOs], 200);
    }
}
