<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: string
{
    case ACTIF = 'actif';
    case ENATTENTE = 'en attente';
    case INACTIF = 'inactif';

    /**
     * @return array<String>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
