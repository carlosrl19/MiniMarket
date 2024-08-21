<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'nombre_proveedor' => 'required|string|min:3|max:55|regex:/^[^\d]+$/|unique:proveedors',
            'rtn_proveedor' => 'required|regex:/^[0-9]+$/|string|min:14|max:14',
            'telefono_proveedor' => 'required|string|min:8|max:8|regex:([2,3,8,9]{1}[0-9]{7})',
            'direccion_proveedor' => 'required|string|min:3|max:255',
            'contacto_proveedor' => 'required|string|min:3|max:55|regex:/^[^\d]+$/',
            'telefono_contacto_proveedor' => 'required|string|min:8|max:8|regex:([2,3,8,9]{1}[0-9]{7})'
        ];
    }

    public function messages()
    {
        return [
            // Product provider company messages
            'nombre_proveedor.required' => 'La empresa proveedora es obligatoria.',
            'nombre_proveedor.string' => 'La empresa proveedora no acepta números ni símbolos.',
            'nombre_proveedor.min' => 'La empresa proveedora debe contener al menos 3 letras.',
            'nombre_proveedor.max' => 'La empresa proveedora no puede exceder 55 letras.',
            'nombre_proveedor.regex' => 'La empresa proveedora debe contener únicamente letras.',
            'nombre_proveedor.unique' => 'La empresa proveedora ya existe.',

            // Product marca messages
            'rtn_proveedor.required' => 'El RTN de la empresa proveedora es obligatorio.',
            'rtn_proveedor.regex' => 'El RTN de la empresa proveedora debe contener únicamente números.',
            'rtn_proveedor.string' => 'El RTN de la empresa proveedora no acepta letras ni símbolos.',
            'rtn_proveedor.min' => 'El RTN de la empresa proveedora debe contener al menos 14 dígitos.',
            'rtn_proveedor.max' => 'El RTN de la empresa proveedora no puede exceder 14 dígitos.',

            // Product model messages
            'telefono_proveedor.required' => 'El teléfono del proveedor es obligatorio.',
            'telefono_proveedor.string' => 'El teléfono del proveedor solo acepta números.',
            'telefono_proveedor.min' => 'El teléfono del proveedor debe contener al menos 8 dígitos.',
            'telefono_proveedor.max' => 'El teléfono del proveedor no puede exceder 8 dígitos.',
            'telefono_proveedor.unique' => 'El teléfono del proveedor ya existe.',
            'telefono_proveedor.regex' => 'El teléfono del proveedor no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',
            
            // Product description messages
            'direccion_proveedor.required' => 'La dirección del proveedor es obligatoria.',
            'direccion_proveedor.string' => 'La dirección del proveedor solo debe contener letras.',
            'direccion_proveedor.min' => 'La dirección del proveedor debe contener al menos 3 letras.',
            'direccion_proveedor.max' => 'La dirección del proveedor no puede exceder 255 letras.',

            // Product existance messages
            'contacto_proveedor.required' => 'El nombre del vendedor del proveedor es obligatoria.',
            'contacto_proveedor.string' => 'El nombre del vendedor del proveedor no acepta números ni símbolos.',
            'contacto_proveedor.min' => 'El nombre del vendedor del proveedor debe contener al menos 3 letras.',
            'contacto_proveedor.max' => 'El nombre del vendedor del proveedorno puede exceder 55 letras.',
            'contacto_proveedor.regex' => 'El nombre del vendedor del proveedor debe contener únicamente letras.',

            // Product model messages
            'telefono_contacto_proveedor.required' => 'El teléfono del vendedor del proveedor es obligatorio.',
            'telefono_contacto_proveedor.string' => 'El teléfono del vendedor del proveedor solo acepta números.',
            'telefono_contacto_proveedor.min' => 'El teléfono del vendedor del proveedor debe contener al menos 8 dígitos.',
            'telefono_contacto_proveedor.max' => 'El teléfono del vendedor del proveedor no puede exceder 8 dígitos.',
            'telefono_contacto_proveedor.regex' => 'El teléfono del vendedor del proveedor no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',
        ];
    }
}
