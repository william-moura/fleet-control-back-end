<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'vehicle_notes',
        'vehicle_chassis_number',
        'vehicle_renavam_number',
        'vehicle_color',
        'vehicle_transmission_type',
        'vehicle_model_year',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'vehicle_purchase_date' => 'datetime',
        'vehicle_plate' => 'string',
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
        return $this->belongsToMany(Driver::class, 'vehicle_relationship_drivers', 'vehicle_id', 'driver_id')->distinct();
    }
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    public function maxKilometer(): HasOne
    {
        return $this->hasOne(Kilometer::class)->orderBy('kilometers_value', 'desc')->limit(1);
    }
    public function fuelSuppliers(): HasMany
    {
        return $this->hasMany(FuelSupplier::class);
    }
    public function maintenances(): HasMany
    {
        return $this->hasMany(MaintenanceControl::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(VehicleFine::class);
    }
    public function totalFines(): float
    {
        return $this->fines()->sum('vehicle_fine_amount');
    }

    public function alertsDueDate(): MorphMany
    {
        return $this->morphMany(AlertsDueDate::class, 'alertable');
    }

    public function kilometers(): HasMany
    {
        return $this->hasMany(Kilometer::class);
    }
}
