<?php

namespace App\DTOs;

use App\Http\Requests\GenerateReportRequest;
use DateTimeImmutable;
class GenerateReportDTO
{
    public function __construct(
        public DateTimeImmutable $startDate,
        public DateTimeImmutable $endDate,
        public array $vehicleIds = [],
        public string $type,
        public ?int $brandId = null,
        public ?int $driverId = null,
    ) {}

    public static function fromRequest(GenerateReportRequest $request): self
    {
        return new self(
            startDate: new DateTimeImmutable($request->input('startDate')),
            endDate: new DateTimeImmutable($request->input('endDate')),
            vehicleIds: $request->input('vehicleId') ?? [],
            type: $request->input('type')?? 'json',
            brandId: $request->input('brandId') ?? null,
            driverId: $request->input('driverId') ?? null,
        );
    }
}