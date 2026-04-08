<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRelationService extends Model
{
    //
    protected $table = 'maintenance_relation_services';
    protected $fillable = ['maintenance_control_id', 'maintenance_service_id', 'maintenance_control_relation_service_price', 'maintenance_control_relation_service_quantity', 'maintenance_control_relation_service_total', 'maintenance_control_relation_service_notes', 'maintenance_control_relation_service_status'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function maintenanceControl()
    {
        return $this->belongsTo(MaintenanceControl::class);
    }
    public function maintenanceService()
    {
        return $this->belongsTo(MaintenanceControlService::class);
    }
}
