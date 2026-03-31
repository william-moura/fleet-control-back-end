<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'suppliers';
    protected $fillable = [
        'supplier_fantasy_name', 
        'supplier_corporate_name', 
        'supplier_cnpj', 
        'supplier_ie', 
        'supplier_address', 
        'supplier_number', 
        'supplier_complement', 
        'supplier_neighborhood', 
        'supplier_city', 
        'supplier_state', 
        'supplier_zip_code', 
        'supplier_phone', 
        'supplier_email', 
        'supplier_status', 
        'supplier_notes'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function fuelSuppliers()
    {
        return $this->hasMany(FuelSupplier::class);
    }
}