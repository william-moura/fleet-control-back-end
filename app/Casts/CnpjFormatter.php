<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class CnpjFormatter implements CastsAttributes
{
    /**
     * Cast ao obter o valor (Formata: 00.000.000/0000-00)
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Remove qualquer caractere não numérico antes de formatar
        $cnpj = preg_replace('/[^a-zA-Z0-9]/', '', $value);

        if (strlen($cnpj) !== 14) {
            return $value; // Retorna original se não for 14 dígitos
        }

        return vsprintf('%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s', str_split($value));        
    }

    /**
     * Cast ao definir o valor (Salva apenas números)
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Remove máscara: pontos, traços e barras
        return preg_replace('/[^A-Za-z0-9]/', '', $value);
    }
}
