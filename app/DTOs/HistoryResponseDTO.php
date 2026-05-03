<?php

namespace App\DTOs;

class HistoryResponseDTO
{
    public function __construct(
        public int $id,
        public string $date,
        public string $type,
        public string $description,
        public float $totalCost,
    ) {}
    public static function fromEntity(object $item): self
    {
        return new self(
            id: $item->id,
            date: $item->date,
            type: $item->type,
            description: $item->description,
            totalCost: $item->totalCost,
        );
    }
}