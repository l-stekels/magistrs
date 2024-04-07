<?php

declare(strict_types=1);

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum Gender: string implements TranslatableInterface
{
    case FEMALE = 'female';
    case MALE = 'male';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::MALE  => 'Vīrietis',
            self::FEMALE => 'Sieviete',
        };
    }
}
