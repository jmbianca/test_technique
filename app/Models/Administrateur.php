<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrateur extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdministrateurFactory> */
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $table = 'administrateurs';

    protected $fillable = [
        'nom',
        'login',
        'mot_de_passe',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }
}
