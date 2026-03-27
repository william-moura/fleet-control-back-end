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
            'driverName' => ['required', 'string', 'max:255'],
            'driverRegisteredNumber' => ['required', 'string', 'max:255'],
            'driverAddress' => ['required', 'string', 'max:255'],
            'driverCity' => ['required', 'string', 'max:255'],
            'driverState' => ['required', 'string', 'max:2'],
            'driverZipCode' => ['required', 'string', 'max:99999999'],
            'driverBloodType' => ['required', 'string', 'max:4'],
            'driverRg' => ['required', 'string', 'max:11'],
            'driverCpf' => ['required', 'string', 'max:11'],
            'driverLicenseNumber' => ['required', 'string', 'max:255'],
            'driverLicenseExpirationDate' => ['required', 'date'],
            'driverLicenseCategory' => ['required', 'string', 'max:3'],
            'driverBirthDate' => ['required', 'date'],
            'driverPhone' => ['required', 'string', 'max:15'],
            'driverStatus' => ['required', 'integer', 'in:0,1'],
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
