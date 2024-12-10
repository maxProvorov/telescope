<?php

namespace App\Enums;

enum MethodEnum: string
{
    case SMS = 'sms';
    case EMAIL = 'email';
    case TELEGRAM = 'telegram';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
