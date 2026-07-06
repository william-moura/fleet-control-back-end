<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Collection;

class ReportResponseDTO
{
    public function __construct(
        public array $columns,
        public array $data,
        public string $title,
    ) {}

    public static function fromEntity(Collection $data): self
    {
        $columns = array_keys($data->first()->getAttributes());
        return new self(
            columns: $columns,
            data: $data->toArray(),
            title: $data->first()->getTitle(),
        );
    }
}