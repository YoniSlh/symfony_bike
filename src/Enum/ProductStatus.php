<?php

namespace App\Enum;

enum ProductStatus: string
{
    case DISPONIBLE = 'disponible';
    case RUPTURE_DE_STOCK = 'en rupture';
    case PRECOMMANDE = 'en précommande';
}
