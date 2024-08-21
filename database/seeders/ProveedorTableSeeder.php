<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder
{
    public function run()
    {
        Proveedor::create(
            [
                'nombre_proveedor'=>'Proveedor genérico',
                'rtn_proveedor'=>'00000000000000',
                'telefono_proveedor'=>'90000000',
                'direccion_proveedor'=>'San Pedro Sula, Honduras',
                'contacto_proveedor'=>'Proveedor genérico',
                'telefono_contacto_proveedor'=>'30000000',
            ]
        );
    }
}
