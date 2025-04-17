<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CommentaireRequest;
use App\Models\Commentaire;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentaireController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/commentaire",
     *     summary="Créer un commentaire",
     *     tags={"Commentaire"},
     *     operationId="createCommentaire",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"profil_id", "contenu"},
     *                 @OA\Property(property="profil_id", type="integer", example=5, description="ID du profil concerné"),
     *                 @OA\Property(property="contenu", type="string", example="Ce profil est top.")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Commentaire créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="commentaire", type="object",
     *                 @OA\Property(property="id", type="integer", example=10),
     *                 @OA\Property(property="profil_id", type="integer", example=5),
     *                 @OA\Property(property="administrateur_id", type="integer", example=1),
     *                 @OA\Property(property="contenu", type="string", example="Ce profil est top."),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *      @OA\Response(
     *          response=400,
     *          description="Vous avez deja posté un commentaire pour ce profil"
     *      )
     * )
     */
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
