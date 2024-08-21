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
            'name' => 'required|string|min:3|max:50|regex:/^[^\d]+$/|unique:clientes',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required',
            'customer' => 'required',
            'address' => 'required|string|min:3|max:150',
            'telephone' => 'required|regex:([2,3,8,9]{1}[0-9]{7})|numeric|unique:clientes',
        ];
    }

    public function messages()
    {
        return [
        // Client name messages
        'name.required' => 'El nombre del cliente es obligatorio.',
        'name.string' => 'El nombre del cliente solo debe contener letras.',
        'name.min' => 'El nombre del cliente debe contener al menos 3 letras.',
        'name.max' => 'El nombre del cliente no puede exceder 50 letras.',

        // Client email messages
        'email.required' => 'El email del cliente es obligatorio',
        'email.string' => 'El email del cliente solo debe contener letras.',
        'email.email' => 'El formato del email del cliente no es válido, ingrese correctamente el email.',
        'email.unique' => 'El email del cliente ya existe.',
        
        // Client type messages
        'type.required' => 'El tipo de cliente en el sistema es obligatorio.',

        // Client customer messages
        'customer.required' => 'El tipo de comprador es obligatorio.',
        
        // Client password messages
        'password.required' => 'La contraseña del cliente es obligatoria',
        'password.confirmed' => 'La contraseña del cliente debe ser confirmada.',
        'password.min' => 'La contraseña debe contener al menos 8 letras.',
        'password.max' => 'La contraseña no puede exceder 50 letras.',
        
        // Client address messages
        'address.required' => 'La dirección del cliente es obligatoria.',
        'address.string' => 'La dirección del cliente solo debe contener letras.',
        'address.min' => 'La dirección del cliente debe contener al menos 3 letas.',
        'address.max' => 'La dirección del cliente no puede exceder 150 letras.',
        
        'telephone.required' => 'El teléfono del empleado es obligatorio.',
        'telephone.unique' => 'El teléfono del empleado ya existe.',
        'telephone.regex' => 'El teléfono del empleado no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',
        'telephone.numeric' => 'El teléfono del empleado solo acepta números.',
        ];
    }
}
