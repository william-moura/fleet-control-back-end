<?php

namespace App\DTOs;

use App\Http\Requests\CreatePrefeituraRequest;

class CreatePrefeituraDTO
{
    public function __construct(
        public string $prefeituraRazaoSocial,
        public string $prefeituraNomeFantasia,
        public string $prefeituraCnpj,
        public string $prefeituraAddress,
        public string $prefeituraCity,
        public string $prefeituraState,
        public string $prefeituraZipCode,
        public string $prefeituraPhone,
        public ?string $prefeituraEmail,
        public ?string $prefeituraWebsite,
        public ?string $prefeituraStatus,
        public ?string $prefeituraAddressNumber,
        public ?string $prefeituraComplement,
        public ?string $prefeituraNeighborhood,
        public ?array $photoId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'prefeitura_razao_social' => $this->prefeituraRazaoSocial,
            'prefeitura_nome_fantasia' => $this->prefeituraNomeFantasia,
            'prefeitura_cnpj' => $this->prefeituraCnpj,
            'prefeitura_address' => $this->prefeituraAddress,
            'prefeitura_city' => $this->prefeituraCity,
            'prefeitura_state' => $this->prefeituraState,
            'prefeitura_zip_code' => $this->prefeituraZipCode,
            'prefeitura_phone' => $this->prefeituraPhone,
            'prefeitura_email' => $this->prefeituraEmail,
            'prefeitura_website' => $this->prefeituraWebsite,
            'prefeitura_status' => $this->prefeituraStatus,
            'prefeitura_address_number' => $this->prefeituraAddressNumber,
            'prefeitura_complement' => $this->prefeituraComplement,
            'prefeitura_neighborhood' => $this->prefeituraNeighborhood
        ];
    }

    public static function fromRequest(CreatePrefeituraRequest $request): self
    {
        return new self(
            prefeituraRazaoSocial: $request->string('razaoSocial')->toString(),
            prefeituraNomeFantasia: $request->string('nomeFantasia')->toString(),
            prefeituraCnpj: $request->string('cnpj')->toString(),
            prefeituraAddress: $request->string('endereco')->toString(),
            prefeituraCity: $request->string('cidade')->toString(),
            prefeituraState: $request->string('uf')->toString(),
            prefeituraZipCode: $request->string('cep')->toString(),
            prefeituraPhone: $request->string('telefone')->toString(),
            prefeituraEmail: $request->input('email'),
            prefeituraWebsite: $request->input('site'),
            prefeituraStatus: $request->input('status', 'active'),
            prefeituraAddressNumber: $request->string('numero')->toString(),
            prefeituraComplement: $request->string('complemento')->toString(),
            prefeituraNeighborhood: $request->string('bairro')->toString(),
            photoId: $request->input('fotoId'),
        );
    }
}
