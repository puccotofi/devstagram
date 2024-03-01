<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;


class ComentarioController extends Controller
{
    //
    public function store(Request $request, User $user, Post $post){
      //  dd('Prueba de conexion con formulario');
      //validar
        $this->validate($request,[
            'comentario'=>'required|max:255'
        ]);
      // guardar
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario'=> $request->comentario
        ]);
      // Imprimir Mensaje
      // back() es para que regrese a la pagina de la que llegó el request y ademas con with le agrega datos
      // en la vista se explota el dato revisando las variables de sesion, como se muestra en el siguiente código
      /*
        @if (session('mensaje'))
            <div class="bg-green-500 text-white mb-5 rounded-lg text-center uppercase font-bold">
                {{session('mensaje')}}
            </div>
        @endif
      */
      return back()->with('mensaje','Comentario Recibido');
    }
}
