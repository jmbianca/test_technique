<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nom
 * @property string $login
 * @property string $mot_de_passe
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\AdministrateurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur whereMotDePasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrateur whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAdministrateur {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $contenu
 * @property int $administrateur_id
 * @property int $profil_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\CommentaireFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereAdministrateurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereContenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereProfilId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Commentaire whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCommentaire {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property int $administrateur_id
 * @property string|null $image_url
 * @property \App\Enums\Status $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProfilFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereAdministrateurId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profil whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProfil {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

