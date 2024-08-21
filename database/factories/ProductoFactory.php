<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'codigo'=> $this->faker->randomElement($array = array ('TEL','TAB','CAB','TEC')).''.$this->faker-> bothify('########????'),
            'marca'=> $this->faker->randomElement($array = array ('Samsung','Apple','LG','Sony')),
            'modelo'=> $this->faker->randomElement($array = array ('AX54','S8+ 5G','7KRT','R56T','A50s')),
            'descripcion'=> $this->faker->randomElement($array = array ('La disponibilidad de los colores puede variar en función del país o proveedor.',
                'Batería de dos días de duración.',
                'Resistencia al agua y al polvo con certificación IP67.',
                'Cámara de alta resolución de 64 MP.')),
            'existencia'=> $this->faker->numberBetween($min = 1, $max = 500),
            'prec_compra'=> $this->faker->randomFloat($nbMaxDecimals = 2, $min = 500, $max = 550),
            'prec_venta_fin'=> $this->faker->randomFloat($nbMaxDecimals = 2, $min = 700, $max = 750),
            'prec_venta_may'=> $this->faker->randomFloat($nbMaxDecimals = 2, $min = 600, $max = 650),
            'id_categoria'=> $this->faker->numberBetween(3,5),
            'imagen_producto'=> $this->faker->randomElement($array = array ('playstation.jpg','xbox.jpg','usb.png', 'auriculares.jpg', 'cargador.webp')),
        ];
    }
}
