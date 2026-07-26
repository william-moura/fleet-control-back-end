<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orgao extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prefeitura_id',
        'orgao_name',
        'orgao_description',
        'orgao_sigla',
        'orgao_status',
    ];

    public function prefeitura()
    {
        return $this->belongsTo(Prefeitura::class);
    }

    public function secretarias()
    {
        return $this->hasMany(Secretaria::class);
    }
}
