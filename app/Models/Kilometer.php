<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kilometer extends Model
{
    use SoftDeletes;
    protected $table = 'kilometers';
    protected $fillable = [
        'vehicle_id', 
        'driver_id', 
        'kilometers_value', 
        'kilometers_date', 
        'kilometers_notes', 
        'kilometers_status', 
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'kilometers_date' => 'datetime',
    ];
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
}
