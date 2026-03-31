<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFuelSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'fuel_type_id' => ['required', 'integer', 'exists:fuel_types,id'],
            'driver_id' => ['required', 'integer', 'exists:drivers,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'fuel_supplier_price' => ['required', 'numeric', 'min:0'],
            'fuel_supplier_quantity' => ['required', 'numeric', 'min:0'],
            'fuel_supplier_total' => ['required', 'numeric', 'min:0'],
            'fuel_supplier_date' => ['required', 'date'],
            'fuel_supplier_kilometers' => ['required', 'numeric', 'min:0'],
            'fuel_supplier_notes' => ['nullable', 'string', 'max:1000'],
            'fuel_supplier_status' => ['required', 'integer', 'in:0,1'],
            'fuel_supplier_invoice_number' => ['nullable', 'string', 'max:255'],
        ];
    }
}
