<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRelationshipDriver extends Model
{
    use SoftDeletes;
    protected $table = 'vehicle_relationship_drivers';
    protected $fillable = ['vehicle_id', 'driver_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function driver(): HasMany
    {
        return $this->hasMany(Driver::class, 'id', 'driver_id');
    }
}
