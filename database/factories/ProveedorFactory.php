<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre_proveedor'=> $this->faker->firstName($gender = null).' '.$this->faker->lastName.' '.$this->faker->randomElement($array = array ('S. de R.L.','S.A.')),
            'rtn_proveedor'=> $this->faker->numerify('070#').'-'.$this->faker->numerify('199#').'-'.$this->faker->numerify('######') ,
            'telefono_proveedor' =>$this->faker->numerify('9#######'),
            'direccion_proveedor'=> $this->faker->address(),
            'contacto_proveedor'=> $this->faker->firstName($gender = null).' '.$this->faker->lastName,
            'telefono_contacto_proveedor' =>$this->faker->numerify('9#######'),
        ];
    }
}
