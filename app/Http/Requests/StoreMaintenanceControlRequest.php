<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMaintenanceControlRequest extends FormRequest
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
            'maintenanceTypes' => ['array'],
            'maintenanceTypes.*' => ['required', 'exists:maintenance_control_services,id'],
            'supplierId' => ['required', 'exists:suppliers,id'],
            'maintenanceDate' => ['required', 'date'],
            'maintenanceKilometers' => ['required', 'numeric', 'min:0'],
            'maintenanceNotes' => ['nullable', 'string', 'max:1000'],
            'maintenanceCost' => ['required', 'numeric', 'min:0'],                        
            'nextMaintenanceDate' => ['nullable', 'date'],
            'status' => ['nullable', 'integer', 'in:0,1'],
            'previsionDateFinish' => ['nullable', 'date'],
            'maintenanceNextKilometers' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
