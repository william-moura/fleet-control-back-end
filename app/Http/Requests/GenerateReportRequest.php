<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
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
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
            'type' => ['nullable', 'string', 'in:daily,weekly,monthly,yearly'],
            'status' => ['nullable', 'string', 'in:pending,completed,cancelled'],
            'vehicleId' => ['nullable', 'exists:vehicles,id'],
            'driverId' => ['nullable', 'exists:drivers,id'],
            'supplierId' => ['nullable', 'exists:suppliers,id'],
            'maintenanceId' => ['nullable', 'exists:maintenance_controls,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'startDate.required' => 'A data de início é obrigatória',
            'endDate.required' => 'A data de fim é obrigatória',
        ];
    }
}
