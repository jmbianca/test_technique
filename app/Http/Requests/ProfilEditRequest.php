<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'image' => 'nullable|image|max:255', // optionnel, mais doit être une image
            'status' => 'required|in:actif,en attente,inactif',
            'id' => 'required|exists:profils,id'
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est requis.',
            'prenom.required' => 'Le prénom est requis.',
            'status.required' => 'Le statut est requis.',
            'status.in' => 'Le statut doit être l\'un des suivants : actif, attente, inactif.',
            'id.required' => 'Le profil est requis.',
            'id.exists' => 'Le profil spécifié n\'existe pas.',
        ];
    }
}
