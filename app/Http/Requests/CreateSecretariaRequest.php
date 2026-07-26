<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSecretariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'orgao_id' => ['required', 'integer', 'exists:orgaos,id'],
            'secretaria_name' => ['required', 'string', 'max:255'],
            'secretaria_email' => ['nullable', 'email', 'max:255'],
            'secretria_responsible_name' => ['nullable', 'string', 'max:255'],
            'secretaria_description' => ['nullable', 'string', 'max:255'],
            'secretaria_sigla' => ['nullable', 'string', 'max:255'],
            'secretaria_status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function messages(): array
    {
        return [
            'orgao_id.required' => 'O órgão é obrigatório',
            'orgao_id.exists' => 'O órgão informado não existe',
            'secretaria_name.required' => 'O nome da secretaria é obrigatório',
            'secretaria_name.string' => 'O nome da secretaria deve ser uma string',
            'secretaria_name.max' => 'O nome da secretaria deve ter no máximo 255 caracteres',
            'secretaria_email.email' => 'O e-mail da secretaria deve ser um e-mail válido',
            'secretaria_email.max' => 'O e-mail da secretaria deve ter no máximo 255 caracteres',
            'secretria_responsible_name.string' => 'O nome do responsável deve ser uma string',
            'secretria_responsible_name.max' => 'O nome do responsável deve ter no máximo 255 caracteres',
            'secretaria_description.string' => 'A descrição da secretaria deve ser uma string',
            'secretaria_description.max' => 'A descrição da secretaria deve ter no máximo 255 caracteres',
            'secretaria_sigla.string' => 'A sigla da secretaria deve ser uma string',
            'secretaria_sigla.max' => 'A sigla da secretaria deve ter no máximo 255 caracteres',
            'secretaria_status.required' => 'O status da secretaria é obrigatório',
            'secretaria_status.in' => 'O status da secretaria deve ser active ou inactive',
        ];
    }
}
