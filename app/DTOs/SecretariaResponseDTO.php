<?php

namespace App\DTOs;

use App\Models\Secretaria;

class SecretariaResponseDTO
{
    public function __construct(
        public int $id,
        public string $nome,
        public ?string $email,
        public ?string $responsavel,
        public ?string $descricao,
        public ?string $sigla,
        public ?OrgaoResponseDTO $orgao = null,
        public ?int $orgaoId = null,
        public ?int $prefeituraId = null
    ) {}

    public static function fromEntity(Secretaria $secretaria): self
    {
        return new self(
            id: $secretaria->id,
            nome: $secretaria->secretaria_name,
            email: $secretaria->secretaria_email,
            responsavel: $secretaria->secretria_responsible_name,
            descricao: $secretaria->secretaria_description,
            sigla: $secretaria->secretaria_sigla,
            orgao: $secretaria->orgao ? OrgaoResponseDTO::fromEntity($secretaria->orgao) : null,
            orgaoId: $secretaria->orgao_id,
            prefeituraId: $secretaria->orgao->prefeitura_id
        );
    }
}