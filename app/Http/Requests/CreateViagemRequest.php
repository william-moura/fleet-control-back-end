<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateViagemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicleId' => ['required', 'integer', 'exists:vehicles,id'],
            'driverId' => ['required', 'integer', 'exists:drivers,id'],
            'departureDate' => ['required', 'date'],
            'returnDate' => ['nullable', 'date', 'after_or_equal:dataHoraSaida'],
            'odometerDeparture' => ['required', 'numeric', 'min:0'],
            'odometerEntry' => ['required', 'numeric', 'min:0'],
            'distanceKm' => ['nullable', 'string'],
            'travelTime' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicleId.required' => 'O veículo é obrigatório',
            'vehicleId.exists' => 'O veículo informado não existe',
            'driverId.required' => 'O motorista é obrigatório',
            'driverId.exists' => 'O motorista informado não existe',
            'dataHoraSaida.required' => 'A data/hora de saída é obrigatória',
            'dataHoraChegada.after_or_equal' => 'A data/hora de chegada deve ser igual ou posterior à saída',
            'odometroSaida.required' => 'O odômetro de saída é obrigatório',
            'odometroChegada.gte' => 'O odômetro de chegada deve ser maior ou igual ao de saída',
            'enderecoOrigem.required' => 'O endereço de origem é obrigatório',
            'enderecoDestino.required' => 'O endereço de destino é obrigatório',
        ];
    }
}
