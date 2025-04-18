<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentaireRequest extends FormRequest
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
            'contenu' => 'required|string|max:255',
            'profil_id' => 'required|exists:profils,id'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'profil_id.required' => 'Le profil est requis.',
            'profil_id.exists' => 'Le profil spécifié n\'existe pas.',
            'contenu.required' => 'Le contenu est requis.',
        ];
    }
}
