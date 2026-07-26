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
            'prefeitura_id' => ['required', 'integer', 'exists:prefeituras,id'],
            'orgao_name' => ['required', 'string', 'max:255'],
            'orgao_description' => ['nullable', 'string', 'max:255'],
            'orgao_sigla' => ['nullable', 'string', 'max:255'],
            'orgao_status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'prefeitura_id.required' => 'A prefeitura é obrigatória',
            'prefeitura_id.exists' => 'A prefeitura informada não existe',
            'orgao_name.required' => 'O nome do órgão é obrigatório',
            'orgao_name.string' => 'O nome do órgão deve ser uma string',
            'orgao_name.max' => 'O nome do órgão deve ter no máximo 255 caracteres',
            'orgao_description.string' => 'A descrição do órgão deve ser uma string',
            'orgao_description.max' => 'A descrição do órgão deve ter no máximo 255 caracteres',
            'orgao_sigla.string' => 'A sigla do órgão deve ser uma string',
            'orgao_sigla.max' => 'A sigla do órgão deve ter no máximo 255 caracteres',
            'orgao_status.required' => 'O status do órgão é obrigatório',
            'orgao_status.in' => 'O status do órgão deve ser active ou inactive',
        ];
    }
}
