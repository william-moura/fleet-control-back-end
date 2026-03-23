<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    protected $table = 'drivers';
    protected $fillable = [
        'driver_registered_number',
        'driver_name',
        'driver_address',
        'driver_city',
        'driver_state',
        'driver_zip_code',
        'driver_blood_type',
        'driver_rg',
        'driver_cpf',
        'driver_license_number',
        'driver_license_expiration_date',
        'driver_license_category',
        'driver_birth_date',
        'driver_phone',
        'driver_status',
    ];
}
