<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contenu' => $this->faker->sentence(),
            'profil_id' => Profil::factory(),
            'administrateur_id' => Administrateur::factory(),
        ];
    }
}
