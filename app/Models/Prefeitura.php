<?php

namespace App\Models;

use App\Casts\CnpjFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prefeitura extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'prefeitura_razao_social',
        'prefeitura_nome_fantasia',
        'prefeitura_cnpj',
        'prefeitura_address',
        'prefeitura_city',
        'prefeitura_state',
        'prefeitura_zip_code',
        'prefeitura_phone',
        'prefeitura_email',
        'prefeitura_website',
        'prefeitura_status',
        'prefeitura_address_number',
        'prefeitura_complement',
        'prefeitura_neighborhood',
    ];
    protected $casts = [
        'prefeitura_cnpj' => CnpjFormatter::class,
    ];

    public function orgaos()
    {
        return $this->hasMany(Orgao::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
