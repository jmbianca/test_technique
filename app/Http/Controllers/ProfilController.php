<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\ProfilDeleteRequest;
use App\Http\Requests\ProfilEditRequest;
use App\Http\Requests\ProfilRequest;
use App\Models\Profil;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/profil",
     *     operationId="listProfils",
     *     tags={"Profil"},
     *     summary="Lister les profils",
     *     description="Retourne la liste de tous les profils",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des profils",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nom", type="string", example="Skywalker"),
     *                 @OA\Property(property="prenom", type="string", example="Luke"),
     *                 @OA\Property(property="status", type="string", example="actif ** n'est present que pour les utilisateurs authentifiés **"),
     *                 @OA\Property(property="image_url", type="string", example="/storage/profils/luke.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-17T14:30:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-17T14:30:00.000000Z")
     *             )
     *         )
     *     )
     * )
     */
    public function list(): JsonResponse
    {
        $profils = Profil::query()->where('status', Status::ACTIF)->get();

        if (auth('sanctum')->check()) {
            return response()->json($profils);
        }

        // Sinon, on cache le champ `status` pour chaque profil
        $profils = $profils->map(function (Profil $profil) {
            return collect($profil)->except('status');
        });

        return response()->json($profils);
    }

    /**
     * @OA\Post(
     *     path="/api/profil",
     *     operationId="createProfil",
     *     tags={"Profil"},
     *     summary="Créer un profil",
     *     description="Crée un nouveau profil (authentification requise)",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"nom", "prenom", "status"},
     *                 @OA\Property(property="nom", type="string", example="Skywalker"),
     *                 @OA\Property(property="prenom", type="string", example="Luke"),
     *                 @OA\Property(property="status", type="string", enum={"actif", "inactif", "en attente"}, example="actif"),
     *                 @OA\Property(property="image", type="file", description="Image de profil (optionnelle)")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profil créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="profil",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nom", type="string", example="Skywalker"),
     *                 @OA\Property(property="prenom", type="string", example="Luke"),
     *                 @OA\Property(property="status", type="string", example="actif"),
     *                 @OA\Property(property="administrateur_id", type="integer", example=1),
     *                 @OA\Property(property="image_url", type="string", example="profils/luke.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-17T14:30:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-17T14:30:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreurs de validation",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation errors"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="nom", type="array", @OA\Items(type="string", example="Le nom est requis.")),
     *                 @OA\Property(property="prenom", type="array", @OA\Items(type="string", example="Le prénom est requis.")),
     *                 @OA\Property(property="status", type="array", @OA\Items(type="string", example="Le statut est requis."))
     *             )
     *         )
     *     )
     * )
     */
    public function create(ProfilRequest $request): JsonResponse
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profils', 'public');
        }

        $adminId = auth()->id();

        $validatedData = $request->validated();
        $validatedData['administrateur_id'] = $adminId;
        $validatedData['image_url'] = $imagePath;

        $profil = Profil::create($validatedData);

        return response()->json($profil, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/profil/{id}",
     *     summary="Modifier un profil",
     *     tags={"Profil"},
     *     operationId="editProfil",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du profil à modifier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="nom", type="string", example="Kenobi"),
     *                 @OA\Property(property="prenom", type="string", example="Ben"),
     *                 @OA\Property(property="status", type="string", example="inactif"),
     *                 @OA\Property(property="image", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil modifié avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="profil", type="object",
     *                 @OA\Property(property="id", type="integer", example=5),
     *                 @OA\Property(property="nom", type="string", example="Kenobi"),
     *                 @OA\Property(property="prenom", type="string", example="Ben"),
     *                 @OA\Property(property="status", type="string", example="inactif"),
     *                 @OA\Property(property="image_url", type="string", example="profils/kenobi.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profil non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
    public function edit(ProfilEditRequest $request, int $id): JsonResponse
    {
        $profil = Profil::find($id);

        if (!$profil) {
            return response()->json(['error' => 'Profil non trouvé'], 404);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profils', 'public');
        }

        $adminId = auth()->id();

        $validatedData = $request->validated();
        $validatedData['administrateur_id'] = $adminId;
        $validatedData['image_url'] = $imagePath;

        $profil->update($validatedData);

        return response()->json($profil, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/profil/{id}",
     *     summary="Supprimer un profil",
     *     tags={"Profil"},
     *     operationId="deleteProfil",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du profil à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profil supprimé")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profil non trouvé"
     *     )
     * )
     */
    public function delete(int $id): JsonResponse
    {
        $profil = Profil::find($id);

        if (!$profil) {
            return response()->json(['error' => 'Profil non trouvé'], 404);
        }

        //effacer l'image eventuellement liée au profil
        if ($profil->image_url && Storage::disk('public')->exists($profil->image_url)) {
            Storage::disk('public')->delete($profil->image_url);
        }

        //effacer les commentaires liées au profil
        $profil->commentaires()->delete();

        $profil->delete();

        return response()->json(['message' => 'Profil supprimé'], 200);
    }

}
