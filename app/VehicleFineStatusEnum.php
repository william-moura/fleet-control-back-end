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
            self::PENDING => 'Pendente',
            self::PAID => 'Pago',
            self::CANCELLED => 'Cancelado',
        };
    }
}
