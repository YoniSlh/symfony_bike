<?php

namespace App\Entity;

enum OrderStatus: string
{
    case PREPARATION = 'en préparation';
    case SHIPPED = 'expédiée';
    case DELIVERED = 'livrée';
    case CANCELLED = 'annulée';

    public function label(): string
    {
        return match($this) {
            self::PREPARATION => 'En préparation',
            self::SHIPPED => 'Expédiée',
            self::DELIVERED => 'Livrée',
            self::CANCELLED => 'Annulée',
        };
    }
}
