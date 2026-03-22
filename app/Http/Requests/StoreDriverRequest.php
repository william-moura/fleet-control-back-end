<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDriverRequest extends FormRequest
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
            'driver_name' => ['required', 'string', 'max:255'],
            'driver_registered_number' => ['required', 'string', 'max:255'],
            'driver_address' => ['required', 'string', 'max:255'],
            'driver_city' => ['required', 'string', 'max:255'],
            'driver_state' => ['required', 'string', 'max:2'],
            'driver_zip_code' => ['required', 'string', 'max:99999999'],
            'driver_blood_type' => ['required', 'string', 'max:4'],
            'driver_rg' => ['required', 'string', 'max:11'],
            'driver_cpf' => ['required', 'string', 'max:11'],
            'driver_license_number' => ['required', 'string', 'max:255'],
            'driver_license_expiration_date' => ['required', 'date'],
            'driver_license_category' => ['required', 'string', 'max:3'],
            'driver_birth_date' => ['required', 'date'],
            'driver_phone' => ['required', 'string', 'max:15'],
            'driver_status' => ['required', 'integer', 'in:1,2'],
        ];
    }
    public function failedValidation(Validator $validator) 
    { 
        throw new HttpResponseException(response()->json([ 
            'success' => false, 
            'message' => 'Erros de validação', 
            'data' => $validator->errors() 
        ])); 
    }

}
