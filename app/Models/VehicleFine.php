<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleFine extends Model
{
    use SoftDeletes;
    protected $table = 'vehicle_fines';
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'vehicle_fine_amount',
        'vehicle_fine_date',
        'vehicle_fine_level',
        'vehicle_fine_points',
        'vehicle_fine_notes',
        'vehicle_fine_status',
        'vehicle_fine_paid_date',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'vehicle_fine_date' => 'datetime',
        'vehicle_fine_paid_date' => 'datetime',
    ];
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
