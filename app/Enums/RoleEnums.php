<?php

namespace App\Enums;

enum RoleEnums: string
{
    case TEACHER = 'teacher';
    case STUDENT = 'student';

    public static function toArray(): array
    {
        return [
            self::TEACHER->value,
            self::STUDENT->value,
        ];
    }
}
