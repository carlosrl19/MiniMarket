<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[^\d]+$/|string|min:2|max:20|unique:categorias',
            'description' => 'required|string|min:2|max:255',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            // Category name messages
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'La categoría ingresada ya existe.',
            'name.string' => 'El nombre de la categoría solo debe contener letras.',
            'name.regex' => 'La  categoría no puede contener números ni símbolos.',
            'name.min' => 'El nombre de la categoría debe contener al menos 2 letras.',
            'name.max' => 'El nombre de la categoría no puede exceder 20 letras.',

            // Category description messages
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción solo debe contener letras.',
            'description.min' => 'El descripción debe contener al menos 2 letras.',
            'description.max' => 'El descripción no puede exceder 255 letras.',

            // Category status messages
            'status.required' => 'El estado de la categoría es obligatorio.',
        ];
    }
}
