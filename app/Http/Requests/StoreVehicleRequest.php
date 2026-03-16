<?php

namespace App\Http\Requests;

use DateTimeImmutable;
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
            'vehiclePlate'           => ['required', 'string', 'unique:vehicles,vehicle_plate', 'max:10'],
            'brandId'                => ['required', 'integer', 'exists:vehicle_brands,id'],
            'vehicleModel'           => ['required', 'string', 'max:255'],
            'vehicleYear'            => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'fuelTypeId'            => ['required', 'integer', 'exists:fuel_types,id'],
            'vehicleTankCapacity'   => ['required', 'numeric', 'min:0'],
            'vehicleCurrentMileage' => ['required', 'integer', 'min:0'],
            'vehicleStatus'          => ['required', 'integer', 'in:1,2'],
            'vehiclePurchaseDate'   => ['nullable', 'date'],
            'vehicleNotes'           => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function getAllData(): array
    {        
        $data = $this->all();
        if ($this->has('vehiclePurchaseDate')) {
            $data['vehiclePurchaseDate'] = new DateTimeImmutable($this->vehiclePurchaseDate);
        }
        return $data;
    }
}