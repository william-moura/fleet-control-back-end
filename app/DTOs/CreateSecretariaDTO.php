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
        public string $secretariaStatus,
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
            'secretaria_status' => $this->secretariaStatus,
        ];
    }

    public static function fromRequest(CreateSecretariaRequest $request): self
    {
        return new self(
            orgaoId: $request->integer('orgao_id'),
            secretariaName: $request->string('secretaria_name')->toString(),
            secretariaEmail: $request->input('secretaria_email'),
            secretriaResponsibleName: $request->input('secretria_responsible_name'),
            secretariaDescription: $request->input('secretaria_description'),
            secretariaSigla: $request->input('secretaria_sigla'),
            secretariaStatus: $request->string('secretaria_status')->toString(),
        );
    }
}
