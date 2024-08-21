<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'type'=> 'Cliente',
            'customer'=> $this->faker->randomElement($array = array ('mayorista','consumidor_final')),
            'address' =>$this->faker->address,
            'telephone' =>$this->faker->numerify('9#######'),
            'image' => 'Perfil (' .$this->faker->numberBetween(1,4 ).$this->faker->numerify('#').').jpg'
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
