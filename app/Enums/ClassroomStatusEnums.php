<?php

namespace App\Enums;

enum ClassroomStatusEnums: string
{
    case ACTIVE = 'active';
    case ARCHIVED = 'archived';

    public static function toArray(): array
    {
        return [
            self::ACTIVE->value,
            self::ARCHIVED->value,
        ];
    }
}