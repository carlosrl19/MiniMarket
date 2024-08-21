<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaTableSeeder extends Seeder
{

    public function run()
    {
        Categoria::create(
            [
                'name'=>'Categoría genérica',
                'description'=>'Categoría genérica.',
                'status'=>'1',
            ]
        );
    }
}
