<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuelType extends Model
{
    use SoftDeletes;
    protected $table = 'fuel_types';
    protected $fillable = ['fuel_type_name'];
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
