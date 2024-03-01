<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //20240215 validar que el usuario este registrado y logueado para ver este home
    public function __construct()
    {
        $this->middleware('auth');
    }
    //20240119
    public function index(){
        //dd('home');
        // Este seria el feed del sistema, primero necesitamos obtener a quienes sigue la persona.
        //auth es la variable de sesion, de alli se tiene user, que es un modelo, y en el modelo user, existe la funcion followings
        // esta funcion es una consulta a la db que retorna los ID de quienes sigue
        // en esta primer version nos arroja un monton de datos que no nos sirven generalmente
        //dd(auth()->user()->followings);
        // para que solo muestre los campos del resultado de la consulta seria con toarray()
        //dd(auth()->user()->followings->toArray());
        
        // Ahora Bien en este caso solo me interesa obtener el id, no todos los campos
        //dd(auth()->user()->followings->pluck('id')->toArray());
        //ese to array seria lo que contiene el campo atributes de la forma anterior.
        
        // Ahora bien para ejecutar la consulta y asignarlo a una variable usamos 
        $ids = auth()->user()->followings->pluck('id')->toArray();
        // ya que tenemos los ids, de a quienes sigue el usuario que tiene la sesion iniciada
        // podemos jalar sus post para el home
        // Para eso usamos el modelo Post y filtramos donde contenga lo que este en el arreglo de ids
        //$variable destino= modelo::whereIn('campo para filtrar',$valores para filtrar);
        // whereIn es para filtrar arreglos, Elocuent tiene muchos metodos
        
        //$posts= Post::whereIn('user_Id',$ids)->paginate(20);
        
        // Ahora para poder mostrar en orden descendente las publicaciones agregamos el 
        // ->latest
        $posts= Post::whereIn('user_Id',$ids)->latest()->paginate(20);

        //dd($posts);

        // PAsar datos a la vista de home        
        return view('home', [
            'posts'=>$posts
        ]);

    }
}
