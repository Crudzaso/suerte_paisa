<?php

namespace App\Enums;

enum LotteryStatus : string
{
    case COMENZADO = 'COMENZADO';
    case AGOTADO = 'AGOTADO';
    case FINALIZADO = 'FINALIZADO';
}
