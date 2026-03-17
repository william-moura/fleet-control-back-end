<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    protected $table = 'vehicles';
    protected $fillable = [
        'vehicle_plate', 
        'brand_id', 
        'vehicle_model', 
        'vehicle_year', 
        'fuel_type_id', 
        'vehicle_tank_capacity', 
        'vehicle_current_mileage', 
        'vehicle_status', 
        'vehicle_purchase_date', 
        'vehicle_notes'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'vehicle_purchase_date' => 'datetime',
    ];
    public function brand()
    {
        return $this->belongsTo(VehicleBrand::class);
    }
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }
}
