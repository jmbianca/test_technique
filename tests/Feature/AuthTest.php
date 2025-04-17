<?php

declare(strict_types=1);

use App\Models\Administrateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_reussit_avec_identifiants_valides(): void
    {
        $admin = Administrateur::factory()->create();

        $response = $this->postJson('/api/login', [
            'login' => 'test',
            'mot_de_passe' => 'hello%cse',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'admin',
            ]);
    }

    public function test_login_echoue_avec_identifiants_invalides(): void
    {
        $admin = Administrateur::factory()->create();

        $response = $this->postJson('/api/login', [
            'login' => 'nope',
            'mot_de_passe' => 'nope',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors',
            ]);
    }
}
