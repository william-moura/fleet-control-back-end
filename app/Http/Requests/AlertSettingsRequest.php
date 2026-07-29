<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlertSettingsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'alerts' => 'required|array',
            'alerts.*.alertType' => 'required|string|max:255',
            'alerts.*.daysBefore' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'alerts.required' => 'Os alertas são obrigatórias.',
            'alerts.*.alertType.required' => 'O tipo de alerta é obrigatório.',
            'alerts.*.alert_type.string' => 'O tipo de alerta deve ser uma string.',
            'alerts.*.alertType.max' => 'O tipo de alerta deve ter menos de 255 caracteres.',
            'alerts.*.daysBefore.required' => 'O número de dias antes é obrigatório.',
            'alerts.*.daysBefore.integer' => 'O número de dias antes deve ser um número inteiro.',
        ];
    }
}