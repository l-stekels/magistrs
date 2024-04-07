<?php

declare(strict_types=1);

namespace App\Enum;

enum WalkerEmotion: string
{
    case SAD = 'sad';
    case HAPPY = 'happy';


    public static function random(): self
    {
        return match (random_int(0, 1)) {
            0 => self::SAD,
            1 => self::HAPPY,
        };
    }
}
