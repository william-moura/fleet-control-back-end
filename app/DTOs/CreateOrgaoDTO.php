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
            // 'orgao_description' => $this->orgaoDescription,
            'orgao_sigla' => $this->orgaoSigla,
            // 'orgao_status' => $this->orgaoStatus ?? 'active',
        ];
    }

    public static function fromRequest(CreateOrgaoRequest $request): self
    {
        return new self(
            prefeituraId: $request->integer('prefeituraId'),
            orgaoName: $request->string('nome')->toString(),
            orgaoDescription: $request->input('descricao'),
            orgaoSigla: $request->input('sigla'),
            orgaoStatus: $request->string('status')->toString(),
        );
    }
}
