<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Auth\Events\Validated;

class PostController extends Controller
{
// Autentificacion de usuario, si no hay una sesion iniciada contrlar acceso
public function __construct(){
    // este middleware auth esta incluido en la seguridad de laravel, impide que se muestren las paginas si no tienen una sesion activa
    // pero tambien pueden limitarse algunos métodos, en este caso queremos que el perfil y los post sean visibles
    // para hacerlo se agregan con la funcion ->except(['metodos','permitidos'])
    $this ->middleware('auth')->except(['index, show']);

}
/*Mostrar la pagina de inicio

    public function index()
    {
        //dd("desde Muro");
        // auth es un helper que contiene las variables de sesion, en este caso accedermos a la de user
        // con esta linea pudieramos debuggear
        //dd(auth()->user());
        //redireccionar
        return view('dashboard');
       

    }
*/   
// VErsion de index con model binding
public function index(User $user){

    //dd("desde Muro");
    // auth es un helper que contiene las variables de sesion, en este caso accedermos a la de user
    // con esta linea pudieramos debuggear
    //dd(auth()->user());
    //redireccionar
    //dd("usuario".$user->username);
    //return view('dashboard');

    // 20230609 Pasar  datos a una vista en este caso user a dashboard
    // en este caso pasamos user, como un parametro, la variable $user, contiene por el route model binding esos datos
    // estos datos se recibirían en la vista de dashboard

    /*********************
     * Visualizando los post
     * 
     * La siguiente linea muestra como aplicar el where usando el modelo
     * creamos la variable $posts 
     * Luego le asignamos el resultado de la funcion where del modelo Post y usamos como parametros indicando
     * el campo de busqueda y luego el valor que obtenemos de la variable $user accediendo a su atributo id
     * finalmente la funcion ->get() es la que ejecuta la consulta
     * $variable = Modelo::where('campo de busqeuda', valor de busqueda)->get();
     *  */

   // $posts = Post::where('user_id',$user->id)->get();
    // En caso de querer Paginar los resultados se reemplaza get() por paginate()
    // el filtrado lo estamos realizando mediante eloquent, por el where
    $posts = Post::where('user_id',$user->id)->latest()->paginate(20);
    // el filtrado lo estamos realizando mediante eloquent, por el where
    // pero pudieramos utilizar la misma relacion que ya se definio en los modelos usando 
    // dd $posts = $user->posts

    //dd($posts);

    /*********************************************
     * IMPORTANTEEEEEEEE
     * *******************************************
     * El modelo vista controlador separa las capas, por seguridad, la vista no sabe lo que pasa en esta capa
     * por l que se le tiene que enviar mediante "llaves" 
     * A continuacion pasamos datos  a la vista
     * la Variable $user contiene los datos de la sesion que sacamos desde la ruta con el route model binding
     * la variable $posts contiene lo que obtuvimos de la consulta y esto se lo tenemos que pasar a la vista 
     * o la vista no los tendrá accesibles
     */
    return view('dashboard', [
        'user'=>$user,
        'posts' => $posts
    ]);
   

}

public function create(){
   return view('post.create');
}

public function store(Request $request){

    // dd('Probando Conexion de la funcion y el formulario');
    // validaciones del formulario
    $this->validate($request,[
        'titulo'=>'required|max:255',
        'descripcion'=> 'required',
        'imagen'=> 'required'
    ]);
    // para almacenar en la base de datos dejamos que eloucuent use el modelo y le pasamos los parametros
    Post::create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'imagen' => $request->imagen,
        'user_id' => auth()->user()->id
    ]);

    /* 
    **********************************
    OTRA FORMA DE CREAR REGISTROS ES CREANDO UNA INSTANCIA DE LA CLASE Y LUEGO METERLE LOS ATRIBUTOS Y LEUGO SAVE
    **********************************
    
    // Creamos una variable
    $post = new Post;
    // agregamos propiedades

    $post->titulo = $request->titulo;
    $post->descripcion =  $request->descripcion;
    $post->imagen = $request->imagen;
    $post->user_id = auth()->user()->id;
    $post->save();
    */
    // despues de guardar queremos redirigir al usuario a su muro

    /* 
    **********************************
    OTRA FORMA DE CREAR REGISTROS 
    Es utilizando las relaciones creadas entre los modelos 
    En este caso user() es la clase donde indicamos que el usuario crea posts
    esto a travez de la relacion que creamos sin relacion no se puede
    **********************************
    */
    /*
    $request->user()->posts()->create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'imagen' => $request->imagen,
        'user_id' => auth()->user()->id
    ]);
    */
    return redirect()->route('posts.index', auth()->user()->username);
}

/* RESOURCE CONTROLLER 
En este caso esta funcion de show, puede recibir un objeto como parametro, este se obtiene desde la ruta,
al obtenerlo de este modo ya se puede jalar automaticamente  y podemos consumirlo o bien reenviarlo como en este caso
que enviaremos a la vista de show, el objeto post para que lo muestre
*/
public function show(User $user, Post $post){
    // reenvio normal
    //return view('post.show');
    // reenvio con resource controller

    return view('post.show',[
        'user' => $user,
        'post' => $post

    ]);
}

/*Eliminar Registros */

public function destroy(Post $post){
    // comprobar que quien intenta eliminar el post es el autor
    /* esta sería una forma de hacerlo desde el código pero Laravel utiliza lo que se llaman policys
    Estas politicas nos serviran para manejar los permisos de usuarios
     if($post->user_id === auth()->user()->id) {
        
        dd('eliminando ', $post->id);
    } else {
        dd(' no autorizado eliminando ');
    }
    */

    // implementando la validación de permisos con policy 
    // este policy regresa un  true o false, y en caso de false se sale 
    $this->authorize('delete',$post);
    // si regresa un true entonces eliminamos
    $post->delete();
    // eliminar la imagen relacionada con el post
    // primero definir la ubicación del archivo, public_path apunta  la ruta publica, luego en la carpeta uploads que nosotros creamos
    // y finalmente tomamos del objeto $post  el valor del campo ->imagen
    $imagen_path = public_path('/uploads/'.$post->imagen);
    // para eliminar el fichero usamos el facade File, este se tiene que importar asi que es importante que se agrege
    // use Illuminate\Support\Facades\File;
    // y luego usamos la funcion de php unlink

    if(File::exists($imagen_path)){
        unlink($imagen_path);
    }

    // regresamos al usuario a su propio muro
    return redirect()->route('posts.index',auth()->user()->username);
}

}
