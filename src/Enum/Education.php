<?php

declare(strict_types=1);

namespace App\Enum;

enum Education: string
{
    case PAMATSKOLA = 'pamata izglītība';
    case VIDUSSKOLA = 'vidējā izglītība';
    case AUGSTAKA = 'augstākā izglītība';
    case PROFESIONALA = 'vidējā profesionālā izglītība';
}
