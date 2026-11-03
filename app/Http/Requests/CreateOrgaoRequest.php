<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrgaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prefeituraId' => ['required', 'integer', 'exists:prefeituras,id'],
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:255'],
            'sigla' => ['nullable', 'string', 'max:255'],
            // 'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'prefeituraId.required' => 'A prefeitura é obrigatória',
            'prefeituraId.exists' => 'A prefeitura informada não existe',
            'nome.required' => 'O nome do órgão é obrigatório',
            'nome.string' => 'O nome do órgão deve ser uma string',
            'nome.max' => 'O nome do órgão deve ter no máximo 255 caracteres',
            'descricao.string' => 'A descrição do órgão deve ser uma string',
            'descricao.max' => 'A descrição do órgão deve ter no máximo 255 caracteres',
            'sigla.string' => 'A sigla do órgão deve ser uma string',
            'sigla.max' => 'A sigla do órgão deve ter no máximo 255 caracteres',
        ];
    }
}
