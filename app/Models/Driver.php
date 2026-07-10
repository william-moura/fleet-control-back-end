<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    protected $table = 'drivers';
    protected $fillable = [
        'driver_registered_number',
        'driver_name',
        'driver_address',
        'driver_city',
        'driver_state',
        'driver_zip_code',
        'driver_blood_type',
        'driver_rg',
        'driver_cpf',
        'driver_license_number',
        'driver_license_expiration_date',
        'driver_license_category',
        'driver_birth_date',
        'driver_phone',
        'driver_status',
        'driver_neighborhood',
        'driver_email',
    ];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function vehicles(): HasManyThrough
    {
        return $this->hasManyThrough(Vehicle::class, VehicleRelationshipDriver::class, 'driver_id', 'id', 'id', 'vehicle_id');
    }

    public function vehicleFines(): HasMany
    {
        return $this->hasMany(VehicleFine::class, 'driver_id', 'id');
    }

    public function kilometers(): HasMany
    {
        return $this->hasMany(Kilometer::class, 'driver_id', 'id');
    }

    public function fuelSupplies(): HasMany
    {
        return $this->hasMany(FuelSupplier::class, 'driver_id', 'id');
    }
}
