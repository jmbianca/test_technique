<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CommentaireRequest;
use App\Models\Commentaire;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentaireController extends Controller
{
    public function create(CommentaireRequest $request): JsonResponse
    {
        $adminId = auth()->id();

        $validatedData = $request->validated();
        $validatedData['administrateur_id'] = $adminId;

        $profilId = $validatedData['profil_id'];
        $commentaire = Commentaire::where('profil_id', $profilId)->where('administrateur_id', $adminId)->first();
        if ($commentaire) {
            return response()->json(['error' => 'Vous avez deja posté un commentaire pour ce profil'], 400);
        }

        $commentaire = Commentaire::create($validatedData);

        return response()->json($commentaire, 201);
    }
}
