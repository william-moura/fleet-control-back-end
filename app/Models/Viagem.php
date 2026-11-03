<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viagem extends Model
{
    use SoftDeletes;

    protected $table = 'viagens';

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'viagem_data_hora_saida',
        'viagem_data_hora_chegada',
        'viagem_odometro_saida',
        'viagem_odometro_chegada',
        'viagem_endereco_origem',
        'viagem_endereco_destino',
        'distancia_Km',
        'tempo_viagem',
    ];

    protected $casts = [
        'viagem_data_hora_saida' => 'datetime',
        'viagem_data_hora_chegada' => 'datetime',
        'viagem_odometro_saida' => 'integer',
        'viagem_odometro_chegada' => 'integer',
        'distancia_Km' => 'string',
        'tempo_viagem' => 'string',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
