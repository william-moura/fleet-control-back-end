<?php

namespace App\DTOs;

use App\Models\Media;
use App\Models\Prefeitura;

class PrefeituraResponseDTO
{
    public function __construct(
        public int $id,
        public ?string $razaoSocial,
        public ?string $nomeFantasia,
        public ?string $cnpj,
        public ?string $email,
        public ?string $telefone,
        public ?string $endereco,
        public ?string $bairro,
        public ?string $numero,
        public ?string $complemento,
        public ?string $cidade,
        public ?string $uf,
        public ?string $cep,        
        public ?string $site,
        public ?string $status,
        public ?array $photos,
    )
    {
        $this->id = $id;
        $this->razaoSocial = $razaoSocial;
        $this->nomeFantasia = $nomeFantasia;
        $this->cnpj = $cnpj;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
        $this->bairro = $bairro;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->cep = $cep;        
        $this->site = $site;
        $this->status = $status;
        $this->photos = $photos;
    }
    public static function fromEntity(Prefeitura $prefeitura): self
    {
        // dd($prefeitura->media->map(fn(Media $media) => $media->toArray())->toArray());
        return new self(
            id: (int)$prefeitura->id,
            razaoSocial: (string)$prefeitura->prefeitura_razao_social,
            nomeFantasia: (string)$prefeitura->prefeitura_nome_fantasia,
            cnpj: (string)$prefeitura->prefeitura_cnpj,
            email: (string)$prefeitura->prefeitura_email,
            telefone: (string)$prefeitura->prefeitura_phone,
            endereco: (string)$prefeitura->prefeitura_address,
            bairro: (string)$prefeitura->prefeitura_neighborhood,
            numero: (string)$prefeitura->prefeitura_address_number,
            complemento: (string)$prefeitura->prefeitura_complement,
            cidade: (string)$prefeitura->prefeitura_city,
            uf: (string)$prefeitura->prefeitura_state,
            cep: (string)$prefeitura->prefeitura_zip_code,            
            site: (string)$prefeitura->prefeitura_website,
            status: (string)$prefeitura->prefeitura_status,
            photos: $prefeitura->media->map(fn(Media $media) => PhotoResponseDTO::fromEntity($media))->toArray(),
        );
    }
}