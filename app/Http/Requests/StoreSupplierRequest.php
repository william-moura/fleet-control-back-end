<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'supplierFantasyName' => ['required', 'string', 'max:255'],
            'supplierCorporateName' => ['required', 'string', 'max:255'],
            'supplierCnpj' => ['required', 'string', 'max:14'],
            'supplierIe' => ['nullable', 'string', 'max:14'],
            'supplierAddress' => ['required', 'string', 'max:255'],
            'supplierNumber' => ['nullable', 'string', 'max:10'],
            'supplierComplement' => ['nullable', 'string', 'max:255'],
            'supplierNeighborhood' => ['nullable', 'string', 'max:255'],
            'supplierCity' => ['required', 'string', 'max:255'],
            'supplierState' => ['required', 'string', 'max:2'],
            'supplierZipCode' => ['nullable', 'string', 'max:9'],
            'supplierPhone' => ['nullable', 'string', 'max:15'],
            'supplierEmail' => ['nullable', 'email', 'max:255'],
            'supplierStatus' => ['required', 'integer', 'in:0,1'],
            'supplierNotes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
