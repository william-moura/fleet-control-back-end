<?php

namespace App\DTOs;

use App\Http\Requests\CreatePrefeituraRequest;

class CreatePrefeituraDTO
{
    public string $prefeituraName;
    public string $prefeituraCnpj;
    public string $prefeituraAddress;
    public string $prefeituraCity;
    public string $prefeituraState;
    public string $prefeituraZipCode;
    public string $prefeituraPhone;
    public string $prefeituraEmail;
    public string $prefeituraWebsite;
    public string $prefeituraStatus;

    public function toArray(): array
    {
        return [
            'prefeitura_name' => $this->prefeituraName,
            'prefeitura_cnpj' => $this->prefeituraCnpj,
            'prefeitura_address' => $this->prefeituraAddress,
            'prefeitura_city' => $this->prefeituraCity,
            'prefeitura_state' => $this->prefeituraState,
            'prefeitura_zip_code' => $this->prefeituraZipCode,
            'prefeitura_phone' => $this->prefeituraPhone,
            'prefeitura_email' => $this->prefeituraEmail,
            'prefeitura_website' => $this->prefeituraWebsite,
            'prefeitura_status' => $this->prefeituraStatus,
        ];    
    }

    public static function fromRequest(CreatePrefeituraRequest $request): self
    {
        return new self(
            prefeituraName: $request->prefeitura_name,
            prefeituraCnpj: $request->prefeitura_cnpj,
            prefeituraAddress: $request->prefeitura_address,
            prefeituraCity: $request->prefeitura_city,
            prefeituraState: $request->prefeitura_state,
            prefeituraZipCode: $request->prefeitura_zip_code,
            prefeituraWebsite: $request->prefeitura_website,
            prefeituraStatus: $request->prefeitura_status,
        );    
    }
}