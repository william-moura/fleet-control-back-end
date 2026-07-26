<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrefeituraRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'prefeitura_name' => 'required|string|max:255',
            'prefeitura_cnpj' => 'required|string|max:14',
            'prefeitura_address' => 'required|string|max:255',
            'prefeitura_city' => 'required|string|max:255',
            'prefeitura_state' => 'required|string|max:255',
            'prefeitura_zip_code' => 'required|string|max:8',
            'prefeitura_phone' => 'required|string|max:15',
            'prefeitura_email' => 'required|email|max:255',
            'prefeitura_website' => 'required|url|max:255',
            'prefeitura_status' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'prefeitura_name.required' => 'O nome da prefeitura é obrigatório',
            'prefeitura_name.string' => 'O nome da prefeitura deve ser uma string',
            'prefeitura_name.max' => 'O nome da prefeitura deve ter no máximo 255 caracteres',
        ];
    }
}