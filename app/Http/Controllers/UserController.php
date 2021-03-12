<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserRole;

use Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("users.index",  ["users"=>$users]);
    }

    public function create()
    {
        $roles = UserRole::all();
        return view("users.create", ["roles"=>$roles]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users',
                'rol' => 'required',
                'password' => 'required|min:6|max:20',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'email.required' => 'El email es requerido',
                'email.unique' => 'El email ya esta registrado',
                'rol.required' => 'El rol de usuario es requerido',
                'password.required' => 'La contraseña es requerida',
                'password.min' => 'La contraseña debe tener minimo :min caracteres',
                'password.max' => 'La contraseña debe tener maximo :max caracteres',
            ]
        );

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->rol;
        $user->save();

        return redirect('usuarios')->with('success', 'Usuario registrado correctamente');
    }

    public function edit($id)
    {
        $roles = UserRole::all();
        $user = User::find($id);
        return view("users.edit", ["roles"=>$roles, "user"=>$user]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'rol' => 'required',
            ],
            [
                'name.required' => 'El nombre es requerido',
                'email.required' => 'El email es requerido',
                'rol.required' => 'El rol de usuario es requerido',
            ]
        );

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password !== "" && $request->password !== NULL){
            $user->password = Hash::make($request->password);
        }        
        $user->role_id = $request->rol;
        $user->save();

        return redirect('usuarios')->with('success', 'Usuario modificado correctamente');
    }
}
