<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    /** @use HasFactory<\Database\Factories\ProfilFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'image_url',
        'status',
        'administrateur_id',
    ];

    //pour caster le champ automatiquement
    protected $casts = [
        'status' => Status::class,
    ];
}
