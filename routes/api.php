<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/profil', [ProfilController::class, 'list']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profil', [ProfilController::class, 'create']);
    Route::post('/commentaire', [CommentaireController::class, 'create']);
    Route::put('/profil/{id}', [ProfilController::class, 'edit']);
    Route::delete('/profil/{id}', [ProfilController::class, 'delete']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
