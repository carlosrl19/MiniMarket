<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Obtener los valores de los precios de venta para usar en las reglas de validación
        $prec_compra = intval($this->input('prec_compra'));
        $prec_venta_may = intval($this->input('prec_venta_may'));
        $prec_venta_fin = intval($this->input('prec_venta_fin'));

        return [
            'codigo' => 'nullable|string|regex:/^[0-9]+$/|min:4|max:13', Rule::unique('productos')->ignore($this->id),
            'marca' => 'required|string|min:3|max:40',
            'modelo' => 'required|string|min:3|max:40', Rule::unique('productos')->ignore($this->id),
            'descripcion' => 'required|string|min:3|max:255',
            'existencia' => 'required|numeric|min:0',
            'prec_compra' => 'required|numeric|min:0.01|max:' . $prec_venta_may,
            'prec_venta_may' => 'required|numeric|min:' . $prec_compra, 'max:' . $prec_venta_fin,
            'prec_venta_fin' => 'required|numeric|min:' . $prec_venta_may, 'max:999999999',
            'id_categoria' => 'required',
            'imagen_producto' => 'image|mimes:jpeg,png,jpg,webp|max:8192' // Default (images/products/.no_image_available.png)
        ];
    }

    public function messages()
    {
        return [
            // Product barcode messages
            'codigo.string' => 'El código de barra del producto solo acepta números.',
            'codigo.min' => 'El código de barra del producto debe contener al menos 4 digitos.',
            'codigo.max' => 'El código de barra del producto no puede exceder 13 digitos.',
            'codigo.unique' => 'El código de barra del producto ya existe.',
            'codigo.regex' => 'El código de barra del producto debe contener únicamente números.',

            // Product marca messages
            'marca.required' => 'La marca del producto es obligatoria.',
            'marca.string' => 'La marca del producto solo debe contener letras.',
            'marca.min' => 'La marca del producto debe contener al menos 3 letras.',
            'marca.max' => 'La marca del producto no puede exceder 40 letras.',

            // Product model messages
            'modelo.required' => 'El modelo del producto es obligatoria.',
            'modelo.string' => 'El modelo del producto solo debe contener letras.',
            'modelo.min' => 'El modelo del producto debe contener al menos 3 letras.',
            'modelo.max' => 'El modelo del producto no puede exceder 40 letras.',
            'modelo.unique' => 'El modelo del producto ya existe.',
            
            // Product description messages
            'descripcion.required' => 'La descripción del producto es obligatoria.',
            'descripcion.string' => 'La descripción del producto solo debe contener letras.',
            'descripcion.min' => 'La descripción del producto debe contener al menos 3 letras.',
            'descripcion.max' => 'La descripción del producto no puede exceder 255 letras.',

            // Product existance messages
            'existencia.required' => 'La existencia del producto es obligatoria.',
            'existencia.numeric' => 'La existencia del producto solo debe contener números.',
            'existencia.min' => 'La existencia del producto debe ser mayor o igual a 0.',

            // Product purchase price
            'prec_compra.numeric' => 'El precio de compra solo debe contener números.',
            'prec_compra.required' => 'El precio de comprar es obligatorio.',
            'prec_compra.min' => 'El precio de compra debe ser superior a L. 0.00.',
            'prec_compra.max' => 'El precio de compra debe ser inferior al precio de venta.',

            // Product may price
            'prec_venta_may.numeric' => 'El precio de venta mayorista solo acepta números.',
            'prec_venta_may.required' => 'El precio de venta mayorista es obligatorio.',
            'prec_venta_may.min' => 'El precio de venta mayorista debe ser superior al precio de compra.',
            'prec_venta_may.max' => 'El precio de venta mayorista debe ser inferior o igual al precio de venta para consumidor final.',

            // Product final price
            'prec_venta_fin.numeric' => 'El precio de venta final solo acepta números.',
            'prec_venta_fin.required' => 'El precio de venta final es obligatorio.',
            'prec_venta_fin.min' => 'El precio de venta final debe ser superior al precio de venta al por mayor.',
            'prec_venta_fin.max' => 'El precio de venta final debe ser inferior que L. 99,999,999.99.',

            // Product id category
            'id_categoria.required' => 'La categoría del producto es obligatoria.',

            // Product image
            'imagen_producto.image' => 'La imagen del producto debe ser un archivo de tipo imagen (.png, .jpeg, .jpg, .webp).',
            'imagen_producto.max' => 'La imagen que intenta subir es demasiado grande, intente optimizar la imagen.()',
        ];
    }
}
