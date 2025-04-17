<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\ProfilDeleteRequest;
use App\Http\Requests\ProfilEditRequest;
use App\Http\Requests\ProfilRequest;
use App\Models\Profil;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function list(): JsonResponse
    {
        $profils = Profil::query()->where('status', Status::ACTIF)->get();

        if (auth('sanctum')->check()) {
            return response()->json($profils);
        }

        // Sinon, on cache le champ `status` pour chaque profil
        $profils = $profils->map(function ($profil) {
            return collect($profil)->except('status');
        });

        return response()->json($profils);
    }

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
