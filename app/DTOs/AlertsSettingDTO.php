<?php

namespace App\DTOs;

use App\Models\AlertsSetting;

class AlertsSettingDTO
{
    public function __construct(
        public string $alertType,
        public int $daysBefore,
    ) {}

    public static function fromEntity(AlertsSetting $entity): self
    {
        return new self(
            $entity->alert_type,
            $entity->days_before,
        );
    }
}