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
            'supplierId' => ['required', 'integer', 'exists:suppliers,id'],
            'fuelTypeId' => ['required', 'integer', 'exists:fuel_types,id'],
            'driverId' => ['required', 'integer', 'exists:drivers,id'],
            'vehicleId' => ['required', 'integer', 'exists:vehicles,id'],
            'fuelSupplierPrice' => ['required', 'numeric', 'min:0'],
            'fuelSupplierQuantity' => ['required', 'numeric', 'min:0'],
            'fuelSupplierTotal' => ['required', 'numeric', 'min:0'],
            'fuelSupplierDate' => ['required', 'date'],
            'fuelSupplierKilometers' => ['required', 'numeric', 'min:0'],
            'fuelSupplierNotes' => ['nullable', 'string', 'max:1000'],
            'fuelSupplierStatus' => ['nullable', 'integer', 'in:0,1'],
            'fuelSupplierInvoiceNumber' => ['nullable', 'string', 'max:255'],
        ];
    }
}
