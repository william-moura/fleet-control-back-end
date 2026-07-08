<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Notifications\DueDateVehicle;
use DateTimeImmutable;
use Illuminate\Http\Request;

class VehicleNotificationController extends Controller
{
    public function store(Request $request, int $id)
    {
        $description = $request->input('notificationDescription');
        $expirationDate = DateTimeImmutable::createFromFormat('d/m/Y', $request->input('notificationExpirationDate'));
        // dd($expirationDate);
        $user = $request->user();
        $vehicle = Vehicle::find($id);
        $vehicle->alertsDueDate()->create([
            'user_id' => $user->id,
            'description' => $description,
            'due_date' => $expirationDate,
            'status' => 'pending',
        ]);
        //$dueDate = new DateTimeImmutable($expirationDate);
        // $user->notify(new DueDateVehicle($vehicle, $description, $expirationDate));
        return response()->json(['message' => 'Notification sent successfully']);
        // $vehicle = Vehicle::find($id);
        // $vehicle->notifications()->create($request->all());
        // return response()->json($vehicle);
    }
}
