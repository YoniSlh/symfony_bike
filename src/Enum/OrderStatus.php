<?php

namespace App\Enum;

enum OrderStatus: string
{
    case EN_PREPARATION = 'en_preparation';
    case EXPEDIEE = 'expediee';
    case LIVREE = 'livree';
    case ANNULEE = 'annulee';

    public function label(): string
    {
        return match ($this) {
            self::EN_PREPARATION => 'En préparation',
            self::EXPEDIEE => 'Expédiée',
            self::LIVREE => 'Livrée',
            self::ANNULEE => 'Annulée',
        };
    }
}
