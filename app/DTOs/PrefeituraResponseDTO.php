<?php

namespace App\DTOs;

use App\Models\Prefeitura;

class PrefeituraResponseDTO
{
    public int $id;
    public ?string $name;
    public ?string $email;
    public ?string $phone;
    public ?string $address;
    public ?string $city;
    public ?string $state;
    public ?string $zip_code;
    public ?string $country;
    public ?string $website;

    public function __construct(
        int $id,
        ?string $name,
        ?string $email,
        ?string $phone,
        ?string $address,
        ?string $city,
        ?string $state,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
    }
    public static function fromEntity(Prefeitura $prefeitura): self
    {
        return new self(
            id: $prefeitura->id,
            name: $prefeitura->prefeitura_name,
            email: $prefeitura->prefeitura_email,
            phone: $prefeitura->prefeitura_phone,
            address: $prefeitura->prefeitura_address,
            city: $prefeitura->prefeitura_city,
            state: $prefeitura->prefeitura_state,
        );
    }
}