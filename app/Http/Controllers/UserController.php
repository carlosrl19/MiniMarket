<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;


class UserController extends Controller
{
    public function index(){
        $users = User::get();
        return view('usuario/usuarios_index')->with('users', $users);
    }

    public function create()
    {
        return view('usuario.usuarios_create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'min:3','max:40','regex:/^[a-zA-Z]+\s[a-zA-Z]+(\s[a-zA-Z]+)?(\s[a-zA-Z]+)?$/'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required'],
            'address' => ['required', 'string','min:3', 'max:250'],
            'telephone' => ['required', 'string', 'min:8', 'max:8', 'regex:/([2,3,8,9]{1}[0-9]{7})/'],
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240'
        ], [
            'name.required' => '¡Debes ingresar tu nombre completo!',
            'name.regex' => '¡Debes ingresar de 2 a 4 nombres, sin incluir símbolos ni números!',
            'name.min' => '¡Ingresa tu nombre completo, sin abreviaturas!',
            'name.max' => '¡Has excedido el limite máximo de 40 letras!',

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

            'telephone.required' => 'El teléfono del empleado es obligatorio.',
            'telephone.string' => 'El teléfono del empleado solo acepta números.',
            'telephone.min' => 'El teléfono del empleado debe contener al menos 8 dígitos.',
            'telephone.max' => 'El teléfono del empleado no puede exceder 8 dígitos.',
            'telephone.regex' => 'El teléfono del empleado no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',

            'image.required' => '¡Debes cargar una imagen!',
            'image.image' => '¡Debes seleccionar una imagen!',
            'image.mimes' => '¡Debes seleccionar una imagen en el formato correcto!'
        ]);

        $input = $request->all();
        $password = $request->input('password');
        $input['password'] = bcrypt($password);

        if ($image = $request->file('image')) {
            $destinationPath = 'images/uploads';
            $file_name = $image->getClientOriginalName();
            $profileImage = $file_name ;
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        User::create($input)->assignRole($request->input('type'));
        return redirect()->route("usuarios.index")->with("exito", "El cliente fue creado de manera exitosa.");
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view("usuario.usuarios_show")->with("user", $user);
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view("usuario.usuarios_edit")->with("user", $user);
    }

    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $this->validate($request, [
            'name' => ['required', 'min:3','max:40','regex:/^[a-zA-Z]+\s[a-zA-Z]+(\s[a-zA-Z]+)?(\s[a-zA-Z]+)?$/'],
            'email' => ['required', 'string', 'email', 'max:70', Rule::unique('users')->ignore($users->id),],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required'],
            'address' => ['required', 'string','min:3', 'max:250'],
            'telephone' => ['required', 'string', 'min:8', 'max:8', 'regex:/([2,3,8,9]{1}[0-9]{7})/'],
        ], [
            'name.required' => '¡Debes ingresar tu nombre completo!',
            'name.regex' => '¡Debes ingresar de 2 a 4 nombres, sin incluir símbolos ni números!',
            'name.min' => '¡Ingresa tu nombre completo, sin abreviaturas!',
            'name.max' => '¡Has excedido el limite máximo de 40 letras!',

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

            'telephone.required' => 'El teléfono del empleado es obligatorio.',
            'telephone.string' => 'El teléfono del empleado solo acepta números.',
            'telephone.min' => 'El teléfono del empleado debe contener al menos 8 dígitos.',
            'telephone.max' => 'El teléfono del empleado no puede exceder 8 dígitos.',
            'telephone.regex' => 'El teléfono del empleado no cumple el formato correcto, debe de iniciar con 2,3,8 o 9 y contener 8 números.',
        ]);

        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'images/uploads/';
            $file_name = $image->getClientOriginalName();
            $profileImage = $file_name ;
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        $users->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $users->assignRole($request->input('type'));

        return redirect()->route("usuarios.index")->with("exito", "El usuario fue actualizado de manera exitosa.");
    }

    public function destroy(User $user){
        try {
            $user->delete();
            return redirect()->route("usuarios.index")->with("exito", "El usuario fue eliminado de manera exitosa.");
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1451) {
                $message = 'Lo siento, no se puede eliminar este usuario porque tiene registros asociados en la tabla de ventas. Si desea eliminar este usuario, primero debe eliminar todos los registros asociados en la tabla de ventas.';
                return view('usuario.usuarios_delete', compact('message'));
            } else {
                return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
            }
        }
    }
}
