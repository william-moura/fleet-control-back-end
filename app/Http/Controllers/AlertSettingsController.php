<?php

namespace App\Http\Controllers;

use App\Models\AlertsSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertSettingsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'alert_type' => 'required|string|max:255',
            'days_before' => 'required|integer',
        ]);
        DB::transaction(function () use ($request) {
            AlertsSetting::updateOrCreate(['alert_type' => $request->alert_type], $request->all());
        });

        return response()->json(['message' => 'Alert setting created successfully'], 201);
    }
}
