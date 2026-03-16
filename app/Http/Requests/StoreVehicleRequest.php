<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme sua lógica de permissão
    }

    public function rules(): array
    {
        return [
            'vehicle_plate'           => ['required', 'string', 'unique:vehicles,vehicle_plate', 'max:10'],
            'brand_id'                => ['required', 'integer', 'exists:brands,id'],
            'vehicle_model'           => ['required', 'string', 'max:255'],
            'vehicle_year'            => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'fuel_type_id'            => ['required', 'integer', 'exists:fuel_types,id'],
            'vehicle_tank_capacity'   => ['required', 'numeric', 'min:0'],
            'vehicle_current_mileage' => ['required', 'integer', 'min:0'],
            'vehicle_status'          => ['required', 'string', 'in:active,inactive,maintenance'],
            'vehicle_purchase_date'   => ['nullable', 'date'],
            'vehicle_notes'           => ['nullable', 'string', 'max:1000'],
        ];
    }
}