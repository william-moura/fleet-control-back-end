<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleRelationshipSecretarias extends Model
{
    use SoftDeletes;
    protected $table = 'vehicle_relationship_secretarias';
    protected $fillable = ['vehicle_id', 'secretaria_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'vehicle_id' => 'integer',
        'secretaria_id' => 'integer',
    ];
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function secretaria(): BelongsTo
    {
        return $this->belongsTo(Secretaria::class);
    }
}