<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authentifie un administrateur",
     *     description="Retourne un token si les identifiants sont valides.",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"login", "mot_de_passe"},
     *                 @OA\Property(property="login", type="string", example="admin"),
     *                 @OA\Property(property="mot_de_passe", type="string", example="secret")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="1|abc123def456..."),
     *              @OA\Property(
     *                  property="admin",
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="nom", type="string", example="test"),
     *                  @OA\Property(property="login", type="string", example="test"),
     *                  @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-17T12:15:01.000000Z"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-17T12:15:01.000000Z")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Identifiants invalides"
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
//        die("test");
        $credentials = $request->validate([
            'login' => ['required'],
            'mot_de_passe' => ['required'],
        ]);

        $admin = Administrateur::where('login', $credentials['login'])->first();

        if (! $admin || ! Hash::check($credentials['mot_de_passe'], $admin->mot_de_passe)) {
            throw ValidationException::withMessages([
                'login' => ['Identifiants incorrects.'],
            ]);
        }

        $token = $admin->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'admin' => $admin,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/logout",
     *     summary="Déconnexion de l'administrateur",
     *     tags={"Authentification"},
     *     operationId="logoutAdmin",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Utilisateur non authentifié"
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
