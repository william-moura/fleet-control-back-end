<?php

namespace App\DTOs;

class DriverResponseDTO
{
    public function __construct(
        public int $id,
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
        public string $status,
    ) {}
    public static function fromEntity(object $driver): self
    {
        return new self(
            id: $driver->id,
            name: $driver->driver_name,
            registeredNumber: $driver->driver_registered_number,
            address: $driver->driver_address,
            city: $driver->driver_city,
            state: $driver->driver_state,
            zipCode: $driver->driver_zip_code,
            bloodType: $driver->driver_blood_type,
            rg: $driver->driver_rg,
            cpf: $driver->driver_cpf,
            licenseNumber: $driver->driver_license_number,
            licenseExpirationDate: $driver->driver_license_expiration_date,
            licenseCategory: $driver->driver_license_category,
            birthDate: $driver->driver_birth_date,
            phone: $driver->driver_phone,
            status: $driver->driver_status,
        );
    }
}