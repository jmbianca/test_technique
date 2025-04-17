<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Administrateur;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentaireTest extends TestCase
{
    use RefreshDatabase;

    public function test_authentifie_peut_creer_un_commentaire(): void
    {
        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('test-token')->plainTextToken;

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/commentaire', [
                'contenu' => 'test',
                'profil_id' => $profil->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['contenu' => 'test']);
    }

    public function test_non_authentifie_ne_peut_creer_un_commentaire(): void
    {
        $admin = Administrateur::factory()->create();

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->post('/api/commentaire', [
                'contenu' => 'test',
                'profil_id' => $profil->id,
            ]);

        $response->assertStatus(302); //redirect login
    }

    public function test_authentifie_ne_peut_creer_qu_un_commentaire_par_profil(): void
    {
        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('test-token')->plainTextToken;

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/commentaire', [
                'contenu' => 'test',
                'profil_id' => $profil->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['contenu' => 'test']);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/commentaire', [
                'contenu' => 'test2',
                'profil_id' => $profil->id,
            ]);

        $response->assertStatus(400);
    }
}
