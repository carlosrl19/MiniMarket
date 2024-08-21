<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {

        //  Dev user
        $us = User::create(
            [
                'name'=>'Dev admin',
                'email'=>'admin@dev.com',
                'password' => bcrypt('H14_Pkz*7v0%'),
                'type'=>'Administrador',
                'customer'=>'mayorista',
                'address'=>'San Pedro Sula, Honduras',
                'telephone'=>'97992867',
                'image'=>'Perfil (0).jpg'
            ]
        );

        $us->assignRole('Administrador');

        //  Admin user
        $us = User::create(
            [
                'name'=>'Jonathan Acai',
                'email'=>'jonathan@acai.com',
                'password' => bcrypt('jona.acai2024'),
                'type'=>'Administrador',
                'customer'=>'mayorista',
                'address'=>'San Pedro Sula, Honduras',
                'telephone'=>'97992867',
                'image'=>'Perfil (1).jpg'
            ]
        );

        $us->assignRole('Empleado');

        $us = User::create(
            [
                'name'=>'Alexandra',
                'email'=>'alexandra@acai.com',
                'password' => bcrypt('alexandrita001'),
                'type'=>'Empleado',
                'customer'=>'mayorista',
                'address'=>'San Pedro Sula, Honduras',
                'telephone'=>'89001122',
                'image'=>'Perfil (1).jpg'
            ]
        );

        $us = User::create(
            [
                'name'=>'Karla',
                'email'=>'karla@acai.com',
                'password' => bcrypt('karla001.acai'),
                'type'=>'Empleado',
                'customer'=>'mayorista',
                'address'=>'San Pedro Sula, Honduras',
                'telephone'=>'89001122',
                'image'=>'Perfil (1).jpg'
            ]
        );

        $us->assignRole('Empleado');
    }
}
