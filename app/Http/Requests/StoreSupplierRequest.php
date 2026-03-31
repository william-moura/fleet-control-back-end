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
            'fantasyName' => ['required', 'string', 'max:255'],
            'corporateName' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:14'],
            'ie' => ['required', 'string', 'max:14'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:10'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:2'],
            'zipCode' => ['required', 'string', 'max:9'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255'],
            'status' => ['required', 'integer', 'in:0,1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
