<?php

namespace App\Enums;

enum AssignmentStatusEnum: string
{
    case ACTIVE = 'active';
    case FINISHED = 'finished';

    public static function toArray(): array
    {
        return [
            self::ACTIVE->value,
            self::FINISHED->value,
        ];
    }
}