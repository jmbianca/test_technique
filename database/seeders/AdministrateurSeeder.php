<?php

namespace Database\Seeders;

use App\Models\Administrateur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On vérifie s'il existe déjà pour éviter les doublons
        if (!Administrateur::where('login', 'test')->exists()) {
            Administrateur::factory()->create([
                'nom' => 'test',
                'login' => 'test',
                'mot_de_passe' => bcrypt('hello%cse'), // au cas où la factory changerait
            ]);
        }
    }
}
