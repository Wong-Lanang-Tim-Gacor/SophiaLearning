<?php

namespace App\Enums;

enum ResourceTypeEnum: string
{
    case ASSIGNMENT = 'assignment';
    case MATERIAL = 'material';
    case ANNOUNCEMENT = 'announcement';

    public static function toArray(): array
    {
        return [
            self::ASSIGNMENT->value,
            self::MATERIAL->value,
            self::ANNOUNCEMENT->value,
        ];
    }
}