<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
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

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
