<?php

declare(strict_types=1);

namespace App\Enum;

enum Education: string
{
    case PAMATA = 'pamata izglītība';
    case VIDEJA = 'vidējā izglītība';
    case AUGSTAKA = 'augstākā izglītība';
}
