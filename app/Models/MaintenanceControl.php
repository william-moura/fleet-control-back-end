<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceControl extends Model
{
    use SoftDeletes;
    protected $table = 'maintenance_control';
    protected $primaryKey = 'id';
    protected $fillable = [
        'vehicle_id',
        'maintenance_control_type_id',
        'supplier_id',
        'maintenance_control_date',
        'maintenance_control_kilometers',
        'maintenance_control_description',
        'maintenance_control_total_cost',
        'maintenance_control_notes',
        'maintenance_control_next_date',
        'maintenance_control_next_kilometers',
        'maintenance_control_status',
        'maintenance_control_previous_date_finished',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'maintenance_control_date' => 'datetime',
        'maintenance_control_next_date' => 'datetime',
        'maintenance_control_previous_date_finished' => 'datetime',
        'maintenance_control_kilometers' => 'float',
        'maintenance_control_next_kilometers' => 'float',
        'maintenance_control_total_cost' => 'float',
        'supplier_id' => 'integer',
        'vehicle_id' => 'integer',
    ];
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
    public function maintenanceRelationServices()
    {
        return $this->hasMany(MaintenanceRelationService::class);
    }
}
