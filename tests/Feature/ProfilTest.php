<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Profil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Administrateur;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    public function test_authentifie_peut_creer_un_profil(): void
    {
        Storage::fake('public');

        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/profil', [
                'nom' => 'Skywalker',
                'prenom' => 'Luke',
                'status' => 'actif',
                'image' => UploadedFile::fake()->image('jedi.jpg'),
            ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['nom' => 'Skywalker']);

        Storage::disk('public')->assertExists('profils/' . basename($response['image_url']));
    }

    public function test_non_authentifie_ne_peut_pas_creer_profil(): void
    {
        $response = $this->postJson('/api/profil', [
            'nom' => 'Solo',
            'prenom' => 'Han',
            'status' => 'actif',
        ]);

        $response->assertStatus(401); // Unauthorized
    }

    public function test_authentifie_peut_modifier_profil(): void
    {
        Storage::fake('public');

        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('test-token')->plainTextToken;

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/profil/' . $profil->id, [
                'nom' => 'Skywalker',
                'prenom' => 'Luke',
                'status' => 'actif',
                'image' => UploadedFile::fake()->image('jedi.jpg'),
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['nom' => 'Skywalker']);

        Storage::disk('public')->assertExists('profils/' . basename($response['image_url']));
    }

    public function test_non_authentifie_ne_peut_modifier_profil(): void
    {
        Storage::fake('public');

        $admin = Administrateur::factory()->create();

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->postJson('/api/profil/' . $profil->id, [
                'nom' => 'Skywalker',
                'prenom' => 'Luke',
                'status' => 'actif',
                'image' => UploadedFile::fake()->image('jedi.jpg'),
            ]);

        $response->assertStatus(401);
    }

    public function test_authentifie_peut_effacer_profil(): void
    {
        Storage::fake('public');

        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('test-token')->plainTextToken;

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->delete('/api/profil/' . $profil->id);

        $response->assertStatus(200);

        Storage::disk('public')->assertMissing('profils/' . $profil->image_url);
    }

    public function test_non_authentifie_ne_peut_effacer_profil(): void
    {
        $admin = Administrateur::factory()->create();

        $profil = Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);

        $response = $this->delete('/api/profil/' . $profil->id);

        $response->assertStatus(302); // redirect to login
    }

    public function test_non_authentifie_peut_lister_profils_sans_status(): void
    {
        $admin = Administrateur::factory()->create();

        for ($i = 0; $i < 10; $i++) {
            Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);
        }
        for ($i = 0; $i < 10; $i++) {
            Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ENATTENTE]);
        }

        $response = $this->get('/api/profil');

        $response->assertStatus(200);

        //extraire le json
        $json = $response->json();

        $this->assertCount(10, $json);//que les actifs

        $json = $json[0];

        $this->assertArrayHasKey('nom', $json);
        $this->assertArrayNotHasKey('status', $json);

    }

    public function test_authentifie_peut_lister_profils_avec_status(): void
    {
        $admin = Administrateur::factory()->create();
        $token = $admin->createToken('test-token')->plainTextToken;

        for ($i = 0; $i < 10; $i++) {
            Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ACTIF]);
        }
        for ($i = 0; $i < 10; $i++) {
            Profil::factory()->create(['administrateur_id' => $admin->id, 'status' => Status::ENATTENTE]);
        }

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/profil');

        $response->assertStatus(200);

        //extraire le json
        $json = $response->json();

        $this->assertCount(10, $json);

        $json = $json[0];

        $this->assertArrayHasKey('nom', $json);
        $this->assertArrayHasKey('status', $json);

    }
}
