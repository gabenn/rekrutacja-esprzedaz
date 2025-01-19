<?php

declare(strict_types=1);

namespace App\Enums;

enum PetStatus: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function getValues(): array
    {
        return [
            self::AVAILABLE,
            self::PENDING,
            self::SOLD,
        ];
    }


}
