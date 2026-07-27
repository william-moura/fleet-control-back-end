<?php

namespace App\DTOs;

use App\Http\Requests\CreateSecretariaRequest;

class CreateSecretariaDTO
{
    public function __construct(
        public int $orgaoId,
        public string $secretariaName,
        public ?string $secretariaEmail,
        public ?string $secretriaResponsibleName,
        public ?string $secretariaDescription,
        public ?string $secretariaSigla,        
    ) {
    }

    public function toArray(): array
    {
        return [
            'orgao_id' => $this->orgaoId,
            'secretaria_name' => $this->secretariaName,
            'secretaria_email' => $this->secretariaEmail,
            'secretria_responsible_name' => $this->secretriaResponsibleName,
            'secretaria_description' => $this->secretariaDescription,
            'secretaria_sigla' => $this->secretariaSigla,
        ];
    }

    public static function fromRequest(CreateSecretariaRequest $request): self
    {
        return new self(
            orgaoId: $request->integer('orgaoId'),
            secretariaName: $request->string('nome')->toString(),
            secretariaEmail: $request->input('email'),
            secretriaResponsibleName: $request->input('responsavel'),
            secretariaDescription: $request->input('descricao'),
            secretariaSigla: $request->input('sigla'),
        );
    }
}
