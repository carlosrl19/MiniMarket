<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string','min:3', 'max:70'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required'],
            'address' => ['required', 'string','min:5', 'max:250'],
            'telephone' => ['required', 'numeric','min:2', 'max:99999999'],
        ],[
            'name.required' => '¡Debes ingresar tu nombre completo!',
            'name.string' => '¡Debes ingresar tu nombre completo, solo se permiten letras!',
            'name.min' => '¡Ingresa tu nombre completo, sin abreviaturas!',
            'name.max' => '¡Has excedido el limite máximo de 70 letras!',

            'email.required' => '¡Debes ingresar tu correo electrónico!',
            'email.string' => '¡Debes ingresar tu correo electrónico, verifica la información!',
            'email.email' => '¡Debes ingresar un correo electrónico válido!',
            'email.max' => '¡Has excedido el limite máximo de 70 letras!',
            'email.unique' => '¡Debes ingresar un correo electrónico diferente!',

            'type.required' => '¡Debes ingresar el tipo de usuario!',

            'password.required' => '¡Debes ingresar una contraseña!',
            'password.confirmed' => '¡Debes confirmar tu contraseña!',
            'password.min' => '¡Debes ingresar una contraseña segura!',

            'address.required' => '¡Debes ingresar tu dirección!',
            'address.string' => '¡Debes ingresar tu dirección, verifica la información!',
            'address.min' => '¡Ingresa tu dirección completa, sin abreviaturas!',
            'address.max' => '¡Has excedido el limite máximo de 250 letras!',

            'telephone.required' => '¡Debes ingresar tu número de teléfono!',
            'telephone.numeric' => '¡Debes ingresar tu teléfono, solo se permiten números!',
            'telephone.min' => '¡Ingresa tu número teléfono completo!',
            'telephone.max' => '¡Ingresa tu número teléfono completo, sin exceder el límite!',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'customer' => 'consumidor_final',
            'address' => $data['address'],
            'telephone' => $data['telephone'],
            'image' => 'Perfil (53).jpg',
        ]);
    }
}
