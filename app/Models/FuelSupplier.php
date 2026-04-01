<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelSupplier extends Model
{
    use SoftDeletes;
    protected $table = 'fuel_suppliers';
    protected $fillable = [
        'supplier_id', 
        'fuel_type_id', 
        'driver_id', 
        'vehicle_id', 
        'fuel_supplier_price', 
        'fuel_supplier_quantity', 
        'fuel_supplier_total', 
        'fuel_supplier_date', 
        'fuel_supplier_kilometers', 
        'fuel_supplier_notes', 
        'fuel_supplier_status', 
        'fuel_supplier_invoice_number'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'fuel_supplier_date' => 'datetime',
    ];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function fuelType()
    {
        return $this->belongsTo(FuelType::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}