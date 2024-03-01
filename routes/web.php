<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Este tipo de rutas ya no es recomendable, por seguridad siempre usar controladores 
Route::get('/', function () {
    return view('inicio');
});
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/**************************************
 * Rutas para perfiles
 ********************************/
// ruta con controlador para mostrar la pagina de creación de perfil
Route::get('/register', [RegisterController::class, 'index'])->name('register');

// ruta para metodo post para guardar el perfil
Route::post('/register', [RegisterController::class, 'store'])->name('register');

// ruta para mostrar el perfil para edicion
Route::get('/editar_perfil',[PerfilController::class, 'index'])->name('perfil.index');
// ruta para guardar el perfil para edicion
Route::post('/editar_perfil',[PerfilController::class, 'store'])->name('perfil.store');



/*************************************
 * RUTAS DE Inicio de sesion 
 ************************************/
// ruta del Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');
//ruta Logout
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
// ruta del Muro
//Route::get('/muro',[PostController::class,'index'])->name('posts.index');

/************
 ROUTE MODEL BINDING

 // ruta del modelo con route model binding, es decir una url dinamica
// en este caso vamos a hacerlo con el nombre del usuario para el modelo
// se pone entre llaves para que sea una variable del modelo si no se indica manda el id
//Route::get('/{user}',[PostController::class,'index'])->name('posts.index');
// al poner : nombre_del_campo, usa el campo que se indique
// Se tiene que mendar el parametro desde antes en el login vease como solucionarlo se usa  ['user' => auth()->user()->username])
{user:username} significa que se enviará una variable esta en especifico es la de user
y en la clase donde la utilizamos en la funcion especifica en este caso en index se tendra que importar el modelo
public function index(User $user)   
**************/
Route::get('/{user:username}',[PostController::class,'index'])->name('posts.index');
//Rutas de Post
Route::get('post/create',[PostController::class, 'create'])->name('post.create');
// ruta para guardar post
Route::post('/post',[PostController::class,'store'])->name('post.store');
/**************************
 * RUTA CON VIARIABLE 
 * ***************************
// ruta para mostrar la fotografia del post, en este caso usaremos una variable en la ruta para enviar el id del post
// ademas sera metodo get pues solo visitaremos la url, y usaremos el metodo show que es para mostrar algo
// cuando se manda a llamar esta ruta debe incluir el parametro que estamos indicando en la variable 
// de este modo en la vista <a href="{{route('post.show',$post)}}">">

*/
//Route::get('/post/{post}',[PostController::class,'show'])->name('post.show');
/**************************
 * RUTA CON MULTIPLES VIARIABLES
 * ***************************
// para poder enviar dos variablas se deben marcar aqui como parametros  entre llaves {} y 
// desde la vista se deben enviar estas dos variables  como aqui

// para enviar multiples variables se han indicado como un arreglo
*/
Route::get('/{user:username}/post/{post}',[PostController::class,'show'])->name('post.show');

// Ruta para guardar las imagenes en el server
//Route::post('/imagenes',[ImagenController::class, 'store'])->name('imagenes.store');
Route::post('/imagen',[ImagenController::class,'store'])->name('imagen.store');

/* RUTAS DE COMENTARIOS */
// ruta para guardar un comentario
Route::post('/{user:username}/post/{post}',[ComentarioController::class,'store'])->name('comentarios.store');

/* RUTA PARA ELIMINAR POST */
/*
    Aqui introducimos el uso de policy que es donde manejaremos los roles y permisos
    para crear un policy es en artisan con
    sail artisan make:policy PostPolicy --model=post
    en esta sintaxis se crea la politica PostPolicy y se asocia al modelo post, para que alli la ejecute de este modo
    artisan genera el código necesario para que funcionen las instrucciones de authorize
    
*/
Route::delete('/posts/{post}',[PostController::class,'destroy'])->name('posts.destroy');

/* Rutas para el like */
//dar like
Route::post('posts/{post}/likes', [LikeController::class, 'store'])->name('posts.like.store');
// eliminar like
Route::delete('posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.like.destroy');

/* Rutas para seguimeinto */
Route::post('/{user:username}/follow',[FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow',[FollowerController::class, 'destroy'])->name('users.unfollow');

