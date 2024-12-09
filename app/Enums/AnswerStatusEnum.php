<?php

namespace App\Enums;

enum AnswerStatusEnum: string
{
    case UNFINISHED = 'unfinished';
    case FINISHED = 'finished';

    public static function toArray(): array
    {
        return [
            self::UNFINISHED->value,
            self::FINISHED->value,
        ];
    }
}
