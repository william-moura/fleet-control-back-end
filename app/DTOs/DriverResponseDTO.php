<?php

namespace App\DTOs;

class DriverResponseDTO
{
    public function __construct(
        public int $id,
        public string $driverName,
        public string $driverRegisteredNumber,
        public string $driverAddress,
        public string $driverCity,
        public string $driverState,
        public string $driverZipCode,
        public string $driverBloodType,
        public string $driverRg,
        public string $driverCpf,
        public string $driverLicenseNumber,
        public string $driverLicenseExpirationDate,
        public string $driverLicenseCategory,
        public string $driverBirthDate,
        public string $driverPhone,
        public string $driverStatus,
    ) {}
    public static function fromEntity(object $driver): self
    {
        return new self(
            id: $driver->id,
            driverName: $driver->driver_name,
            driverRegisteredNumber: $driver->driver_registered_number,
            driverAddress: $driver->driver_address,
            driverCity: $driver->driver_city,
            driverState: $driver->driver_state,
            driverZipCode: $driver->driver_zip_code,
            driverBloodType: $driver->driver_blood_type,
            driverRg: $driver->driver_rg,
            driverCpf: $driver->driver_cpf,
            driverLicenseNumber: $driver->driver_license_number,
            driverLicenseExpirationDate: $driver->driver_license_expiration_date,
            driverLicenseCategory: $driver->driver_license_category,
            driverBirthDate: $driver->driver_birth_date,
            driverPhone: $driver->driver_phone,
            driverStatus: $driver->driver_status,
        );
    }
}