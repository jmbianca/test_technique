<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperProfil
 */
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

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }
}
