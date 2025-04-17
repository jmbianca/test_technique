<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/profil', [ProfilController::class, 'list']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profil/{id}', [ProfilController::class, 'edit']); //PHP ne gère pas multipart/form-data avec PUT par défaut, donc POST (on peut sinon rajouter un param _method=PUT pour garder PUT au niveau de la route)
    Route::post('/profil', [ProfilController::class, 'create']);
    Route::post('/commentaire', [CommentaireController::class, 'create']);
    Route::delete('/profil/{id}', [ProfilController::class, 'delete']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
