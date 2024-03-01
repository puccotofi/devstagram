<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        //return dd ("Autenticando");
        // Validación de los campos del formulario de login
        $this->validate($request,[
            'email'=> 'required|min:4|max:60|email',
            'password'=>'required' 
        ]);
        // una vez validados los campos vemos si se puede autenticar, para eso usamos de nuevo el auth
        if(!auth()->attempt($request->only('email', 'password'),$request->remember))
        {
            return back()->with('mensaje', "Credenciales Incorrectas");
        }else{
           // return redirect()->route('posts.index');
           // versión de envio al muro con la url personalizada mediante route model binding
            return redirect()->route('posts.index', ['user' => auth()->user()->username]);
        }
    }
}
