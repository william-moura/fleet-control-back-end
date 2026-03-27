<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
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
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(Driver::class, 'vehicle_relationship_drivers', 'vehicle_id', 'driver_id');
    }
}
