<?php

namespace App\DTOs;

use App\Http\Requests\GenerateReportRequest;
use DateTimeImmutable;
class GenerateReportDTO
{
    public function __construct(
        public DateTimeImmutable $startDate,
        public DateTimeImmutable $endDate,
        public ?int $vehicleId = null,
        public string $type,
    ) {}

    public static function fromRequest(GenerateReportRequest $request): self
    {
        return new self(
            startDate: new DateTimeImmutable($request->input('startDate')),
            endDate: new DateTimeImmutable($request->input('endDate')),
            vehicleId: $request->input('vehicleId'),
            type: $request->input('type')?? 'json',
        );
    }
}