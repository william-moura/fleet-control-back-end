<?php

namespace App\Contracts;

use App\DTOs\GenerateReportDTO;
use Illuminate\Database\Eloquent\Collection;

interface ReportContract
{
    public function getDados(GenerateReportDTO $dto): Collection;
    public function getHeadings(): array;
    public function getTitle(): string;
}