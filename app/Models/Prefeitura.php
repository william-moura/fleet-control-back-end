<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefeitura extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prefeitura_name',
        'prefeitura_cnpj',
        'prefeitura_address',
        'prefeitura_city',
        'prefeitura_state',
        'prefeitura_zip_code',
        'prefeitura_phone',
        'prefeitura_email',
        'prefeitura_website',
        'prefeitura_status',
    ];

    public function orgaos()
    {
        return $this->hasMany(Orgao::class);
    }
}
