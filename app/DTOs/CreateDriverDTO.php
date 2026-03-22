<?php

namespace App\DTOs;

use App\Http\Requests\StoreDriverRequest;
use Illuminate\Http\Request;

class CreateDriverDTO
{
    public function __construct(
        public string $name,
        public string $registeredNumber,
        public string $address,
        public string $city,
        public string $state,
        public string $zipCode,
        public string $bloodType,
        public string $rg,
        public string $cpf,
        public string $licenseNumber,
        public string $licenseExpirationDate,
        public string $licenseCategory,
        public string $birthDate,
        public string $phone,
        public string $status
    ) {}
    public static function fromRequest(StoreDriverRequest $request): self
    {
        return new self(
            name: $request->driver_name,
            registeredNumber: $request->driver_registered_number,
            address: $request->driver_address,
            city: $request->driver_city,
            state: $request->driver_state,
            zipCode: $request->driver_zip_code,
            bloodType: $request->driver_blood_type,
            rg: $request->driver_rg,
            cpf: $request->driver_cpf,
            licenseNumber: $request->driver_license_number,
            licenseExpirationDate: $request->driver_license_expiration_date,
            licenseCategory: $request->driver_license_category,
            birthDate: $request->driver_birth_date,
            phone: $request->driver_phone,
            status: $request->driver_status,
        );
    }
}