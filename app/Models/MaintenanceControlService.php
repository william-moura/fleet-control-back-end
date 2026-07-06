<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceControlService extends Model
{
    use SoftDeletes;
    protected $table = 'maintenance_control_services';
    protected $fillable = ['maintenance_control_service_name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function maintenanceControls()
    {
        return $this->hasMany(MaintenanceControl::class);
    }
}
