<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleBrand extends Model
{
    //
    protected $table = 'vehicle_brands';
    protected $fillable = ['brand_name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
