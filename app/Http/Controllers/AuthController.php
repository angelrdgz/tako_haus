<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            switch (Auth::user()->role_id) {
                case 1:
                    return redirect()->intended('dashboard');
                    break;
                case 2:
                    return redirect()->intended('cuentas');
                    break;
                case 3:
                    return redirect()->intended('ordenes-de-fabricacion');
                    break;
                case 4:
                    return redirect()->intended('ordenes-de-compra');
                    break;
                case 5:
                    return redirect()->intended('bitacora');
                    break;

                default:
                    return redirect()->intended('bitacora');
                    break;
            }
        } else {
            return redirect()->back()->with('error', 'Email y/o contrasela incorrectos');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Cerró sesión correctamente.');
    }
}
