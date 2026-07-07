<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Notifications\DueDateVehicle;
use DateTimeImmutable;
use Illuminate\Http\Request;

class VehicleNotificationController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $vehicle = Vehicle::find($id);
        $dueDate = new DateTimeImmutable($request->notificationExpirationDate);
        $user->notify(new DueDateVehicle($vehicle, $request->notificationDescription, $dueDate));
        return response()->json(['message' => 'Notification sent successfully']);
        // $vehicle = Vehicle::find($id);
        // $vehicle->notifications()->create($request->all());
        // return response()->json($vehicle);
    }
}
