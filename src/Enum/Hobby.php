<?php

declare(strict_types=1);

namespace App\Enum;

enum Hobby: string
{
    case GRAMATAS = 'Grāmatu lasīšana';
    case FOTO = 'Fotogrāfēšana';
    case DARZS = 'Dārzkopība';
    case CELOSANA = 'Ceļošana';
    case MAKSKERESANA = 'Makšķerēšana';
    case DATORSPELES = 'Datorspēles';
    case KOKAPSTRADE = 'Kokapstrāde';
    case KULINARIJA = 'Kulinārija';
    case MUZIKA = 'Mūzika';
    case RAKSTISANA = 'Rakstīšana';
    case SKRIESANA = 'Skriešana';
    case SPORTS = 'Sports';
    case MAKSLA = 'Māksla';
    case MEDITACIJA = 'Meditācija';
}
