<?php

namespace App\DTOs;

use App\Http\Requests\StoreDriverRequest;
use Illuminate\Http\Request;

class CreateDriverDTO
{
    public function __construct(
        public string $name,
        public ?string $registeredNumber = null,
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
        public array $photosIds = [],
        public string $neighborhood,
        public string $email,
    ) {}
    public static function fromRequest(StoreDriverRequest $request): self
    {
        return new self(
            name: $request->driverName,
            registeredNumber: $request->driverRegisteredNumber ?? null,
            address: $request->driverAddress,
            city: $request->driverCity,
            state: $request->driverState,
            zipCode: $request->driverZipCode,
            bloodType: $request->driverBloodType,
            rg: $request->driverRg,
            cpf: $request->driverCpf,
            licenseNumber: $request->driverLicenseNumber,
            licenseExpirationDate: $request->driverLicenseExpirationDate,
            licenseCategory: $request->driverLicenseCategory,
            birthDate: $request->driverBirthDate,
            phone: $request->driverPhone,
            status: $request->driverStatus,
            photosIds: $request->photosIds,
            neighborhood: $request->driverNeighborhood,
            email: $request->driverEmail,
        );
    }
}