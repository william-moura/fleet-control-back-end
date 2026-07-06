<?php

namespace App;

enum VehicleFineStatusEnum:int
{
    case PENDING = 1;
    case PAID = 2;    
    case CANCELLED = 0;

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'pendente',
            self::PAID => 'pago',
            self::CANCELLED => 'cancelado',
        };
    }
    public function value(): int
    {
        return match($this) {
            self::PENDING => 1,
            self::PAID => 2,
            self::CANCELLED => 0,
        };
    }
    public static function fromValue(int $value): self
    {
        return match($value) {
            1 => self::PENDING,
            2 => self::PAID,
            0 => self::CANCELLED,
        };
    }
    public static function values(): array
    {
        return [
            self::PENDING->value(),
            self::PAID->value(),
            self::CANCELLED->value(),
        ];
    }
    public static function labels(): array
    {
        return [
            self::PENDING->label(),
            self::PAID->label(),
            self::CANCELLED->label(),
        ];
    }
    public static function fromLabel(string $label): self
    {
        return match($label) {
            'pendente' => self::PENDING,
            'pago' => self::PAID,
            'cancelado' => self::CANCELLED,
        };
    }
}
