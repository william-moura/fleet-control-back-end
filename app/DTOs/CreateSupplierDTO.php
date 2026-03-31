<?php

namespace App\DTOs;

use App\Http\Requests\StoreSupplierRequest;

class CreateSupplierDTO
{
    public function __construct(
        public string $fantasyName,
        public string $corporateName,
        public string $cnpj,
        public string $ie,
        public string $address,
        public string $number,
        public string $complement,
        public string $neighborhood,
        public string $city,
        public string $state,
        public string $zipCode,
        public string $phone,
        public string $email,
        public int $status,
        public string $notes,
    ) {}

    public static function fromRequest(StoreSupplierRequest $request): self
    {
        return new self(
            fantasyName: $request->fantasyName,
            corporateName: $request->corporateName,
            cnpj: $request->cnpj,
            ie: $request->ie,
            address: $request->address,
            number: $request->number,
            complement: $request->complement,
            neighborhood: $request->neighborhood,
            city: $request->city,
            state: $request->state,
            zipCode: $request->zipCode,
            phone: $request->phone,
            email: $request->email,
            status: $request->status,
            notes: $request->notes,
        );
    }
    public function toArray(): array
    {
        return [
            'fantasyName' => $this->fantasyName,
            'corporateName' => $this->corporateName,
            'cnpj' => $this->cnpj,
            'ie' => $this->ie,
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'zipCode' => $this->zipCode,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}