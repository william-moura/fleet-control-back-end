<?php

namespace App\DTOs;

use App\Http\Requests\CreateOrgaoRequest;

class CreateOrgaoDTO
{
    public function __construct(
        public int $prefeituraId,
        public string $orgaoName,
        public ?string $orgaoDescription,
        public ?string $orgaoSigla,
        public string $orgaoStatus,
    ) {
    }

    public function toArray(): array
    {
        return [
            'prefeitura_id' => $this->prefeituraId,
            'orgao_name' => $this->orgaoName,
            'orgao_description' => $this->orgaoDescription,
            'orgao_sigla' => $this->orgaoSigla,
            'orgao_status' => $this->orgaoStatus,
        ];
    }

    public static function fromRequest(CreateOrgaoRequest $request): self
    {
        return new self(
            prefeituraId: $request->integer('prefeitura_id'),
            orgaoName: $request->string('orgao_name')->toString(),
            orgaoDescription: $request->input('orgao_description'),
            orgaoSigla: $request->input('orgao_sigla'),
            orgaoStatus: $request->string('orgao_status')->toString(),
        );
    }
}
