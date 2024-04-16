<?php

declare(strict_types=1);

namespace App\Enum;

enum Emotion: string
{
    case INTERESE = "interese";
    case UZJAUTRINAJUMS = "uzjautrinājums";
    case LEPNUMS = "lepnums";
    case PRIEKS = "prieks";
    case BAUDA = "bauda";
    case APMIERINAJUMS = "apmierinājums";
    case MILESTIBA = "mīlestība";
    case APBRINA = "apbrīna";
    case ATVIEGLOJUMS = "atvieglojums";
    case LIDZJUTIBA = "līdzjūtība";
    case SKUMJAS = "skumjas";
    case VAINA = "vaina";
    case NOZELA = "nožēla";
    case KAUNS = "kauns";
    case VILSANAS = "vilšanās";
    case BAILES = "bailes";
    case RIEBUMS = "riebums";
    case NICINAJUMS = "nicinājums";
    case NAIDS = "naids";
    case DUSMAS = "dusmas";

    public static function pick(?string $value): ?Emotion
    {
        return self::cases()[$value] ?? null;
    }

    public static function values(): array
    {
        return array_map(static fn (Emotion $emotion) => $emotion->value, self::cases());
    }
}
