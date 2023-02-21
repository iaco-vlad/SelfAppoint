<?php

namespace App\Helpers\Enums;

class EventStatusEnum
{
    public const PENDING = 'pending';
    public const CANCELED = 'canceled';
    public const CONFIRMED = 'confirmed';
    public const DECLINED = 'declined';
    public const HONORED = 'honored';
    public const UNHONORED = 'unhonored';

    public static function getMap(): array
    {
        return [
            self::PENDING,
            self::CANCELED,
            self::CONFIRMED,
            self::DECLINED,
            self::HONORED,
            self::UNHONORED,
        ];
    }
}
