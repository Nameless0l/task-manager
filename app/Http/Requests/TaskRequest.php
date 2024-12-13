<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'status' => 'required|in:À faire,En cours,Terminée',
            'due_date' => 'nullable|date|after_or_equal:today'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de la tâche est obligatoire',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères',
            'status.required' => 'Le statut est obligatoire',
            'status.in' => 'Le statut doit être : À faire, En cours ou Terminée',
            'due_date.date' => 'La date d\'échéance doit être une date valide',
            'due_date.after_or_equal' => 'La date d\'échéance doit être aujourd\'hui ou une date future'
        ];
    }
}
