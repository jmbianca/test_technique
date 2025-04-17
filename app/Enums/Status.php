<?php

namespace App\Enums;

enum Status: string
{
    case ACTIF = 'actif';
    case ENATTENTE = 'en_attente';
    case INACTIF = 'inactif';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
