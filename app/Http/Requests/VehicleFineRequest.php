<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleFineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vehicleId' => ['required', 'exists:vehicles,id'],
            'driverId' => ['required', 'exists:drivers,id'],
            'vehicleFineAmount' => ['required', 'numeric'],
            'vehicleFineDate' => ['required', 'date'],
            'vehicleFineLevel' => ['required', 'string', Rule::in(['leve', 'media', 'grave', 'gravissima'])],
            'vehicleFinePoints' => ['required', 'numeric'],
            'vehicleFineNotes' => ['nullable', 'string'],
            'vehicleFineStatus' => ['required', 'integer', 'in:1,2'],
            'vehicleFinePaidDate' => ['nullable', 'date'],
        ];
    }
}
