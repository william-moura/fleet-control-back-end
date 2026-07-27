<?php

namespace App\DTOs;

use App\Models\Orgao;

class OrgaoResponseDTO
{
    public int $id;
    public string $nome;
    public ?string $descricao;
    public string $sigla;
    public ?string $status;
    public PrefeituraResponseDTO $prefeitura;
    public int $prefeituraId;

    public function __construct(int $id, string $nome, ?string $descricao, string $sigla, ?string $status, PrefeituraResponseDTO $prefeitura, int $prefeituraId)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->sigla = $sigla;
        $this->status = $status;
        $this->prefeitura = $prefeitura;
        $this->prefeituraId = $prefeituraId;
    }

    public static function fromEntity(Orgao $orgao): OrgaoResponseDTO
    {
        return new OrgaoResponseDTO(
            id: $orgao->id,
            nome: $orgao->orgao_name,
            descricao: $orgao->orgao_description ?? null,
            sigla: $orgao->orgao_sigla,
            status: $orgao->orgao_status,
            prefeitura: PrefeituraResponseDTO::fromEntity($orgao->prefeitura),
            prefeituraId: $orgao->prefeitura_id,
        );
    }
}