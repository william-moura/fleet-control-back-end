<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrefeituraRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'razaoSocial' => 'required|string|max:255',
            'nomeFantasia' => 'required|string|max:255',
            'cnpj' => 'required|string|max:14',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:255',
            'cep' => 'required|string|max:8',
            'telefone' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'site' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'complemento' => 'nullable|string|max:255',
            'fotoId' => 'nullable|array',
            'fotoId.*' => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'razaoSocial.required' => 'O nome da prefeitura é obrigatório',
            'razaoSocial.string' => 'O nome da prefeitura deve ser uma string',
            'razaoSocial.max' => 'O nome da prefeitura deve ter no máximo 255 caracteres',
        ];
    }
}