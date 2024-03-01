<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store()
    {
        // para cerrar la sesión usarmos el helper de auth
        //dd('Cerrando Sesion');
        auth()->logout();
        
        return redirect()->route('login');
    }
}
