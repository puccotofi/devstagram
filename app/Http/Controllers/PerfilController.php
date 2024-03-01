<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    /************************
     * Proteccion para poder entrar a la edicion solo consesion iniciada, t
     */
    //
    public function __construct(){
        $this->middleware('auth');
    }
    // mostrar el perfil para edición
    public function index(){
        //dd('probando conexion');
        return view('perfil.index');
    }

    public function store(Request $request){

        //dd('prueba de conexion');

        $request->request->add(['username'=> Str::slug($request->username)]);
        // validación de los datos del formulario
        // tipo de validacion diferente, ahora pasamos las reglas como un arreglo arreglo 
        // se incluyen nuevas reglas de que no este en una lista, y en caso de que elija su propio nombre 
        // no genere error, en unique se concatena columna y se pasa el id, no se por que pero asi funciona
        $this->validate($request,[
            'username'=> ['required', 'unique:users,username,'.auth()->user()->id,'min:3','max:20',
            'not_in:twitter,facebook, editar-perfil'],
            'email'=> ['required','unique:users,email,'.auth()->user()->id,'min:4','max:60','email'],
            'password'=>'required'
        ]);

        // encontrar al usuario y cargar el registro del usuario, importamos el modelo de usuario
        $usuario = User::find(auth()->user()->id);

        // en caso de cambio de password primero validar que el que se ingresó sea el mismo
        //$password_verificar =Hash::make($request->password);
        //if(!auth()->attempt($request->only('email', 'password'),$request->remember))
        
        //dd($password_verificar);
        //if($password_verificar === $usuario->password){
        if(password_verify($request->password,$usuario->password)){
        //if(auth()->attempt($request->only('email', 'password'))){
            //dd($request);
            // aqui voy a asignar el numobre del usuario si no vienen en el request que use el mismo
            $usuario->username = $request->username ?? $usuario->username;
            // aqui voy a asignar el email, si no viene en el request entonces que use el mismo
            $usuario->email = $request->email ?? $usuario->email;
            // validación de que se haya enviado una imagen
            // aqui voy a asignar el nuevo Password, si no viene en el request entonces que use el mismo
            
            if($request->password_nuevo){
                $password_nuevo = Hash::make($request->password_nuevo);
                //dd($password_nuevo);
                $usuario->password = $password_nuevo;
            }else{
                //dd("no cambia password");
            }

            // para ello usamos lo que contiene request
            if($request->imagen){
                //return dd('desde imagenes controller');
                // $input = $request->all();
                $imagen = $request->file('imagen');

                // crear un nombre unico para el archivo, para eso se usa el helper STR y su funcion uuid que genera un identificador unico
                $nombreImagen = Str::uuid().".". $imagen->extension();

                // crear instancia de la Imagen
                $imagen_servidor = Image::make($imagen);
                // modificar el tamaño de la imagen
                $imagen_servidor ->fit(1000,1000);
                // Para guardar la Imagagen
                // crear un path
                $imagen_path = public_path('perfiles').'/'.$nombreImagen;
                // guardar la imagen en el servidor
                $imagen_servidor ->save($imagen_path);
                
                // actualizar el campo de la imagen en la tabla del usuario
                
                // si existe un nombre imagen será el asignado de lo contrario vacio
                $usuario -> imagen = $nombreImagen??auth()->user()->imagen??'';
            
            }else{
                $usuario->imagen = auth()->user()->imagen;
            }
            // instruccion guardado
            
            $usuario->save();
        }else{ // password Incorrecto
            //return back()->with('mensaje', "Credenciales Incorrectas :req ".$request->password.' usuario'.$usuario->password);
            return back()->with('mensaje', "Password Incorrecto");
        }
        
         // redireccionar al usuario, no se puede usar simplemente back o el usuario en auth por que pudieron haberlo cambiado
         // cosa con la que no estoy deacuerdo
         return redirect()->route('posts.index',$usuario->username)->with('mensaje',"Perfil Actualizado Correctamente");
    }
}
