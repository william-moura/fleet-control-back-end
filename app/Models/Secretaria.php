<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Secretaria extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'orgao_id',
        'secretaria_name',
        'secretaria_email',
        'secretaria_responsible_name',
        'secretaria_description',
        'secretaria_sigla',
        'secretaria_status',
    ];

    public function orgao()
    {
        return $this->belongsTo(Orgao::class);
    }

    public function veiculos()
    {
        return $this->hasMany(Vehicle::class);
    }
}
