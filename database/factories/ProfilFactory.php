<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Administrateur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'status' => null,  //sera passé en param au moment de la creation
            'administrateur_id' => null, //sera passé en param au moment de la creation
            'image_url' => null,
        ];
    }
}
