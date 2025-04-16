<?php

namespace App\Enums;

enum Status: string
{
    case Actif = 'actif';
    case EnAttente = 'en_attente';
    case Inactif = 'inactif';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
