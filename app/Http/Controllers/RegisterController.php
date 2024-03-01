<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // esta es la sintaxis del closure que estaba en la ruta
    public function index () 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // para debuguear podemos usar bb
        //dd ("el nombre del usuario es :".$request ->get('username'));
        // laravel incluye validaciones para eso usamos Validate
        /*
        usamos el this para referirnos a esta instancia
        luego flecha para acceder al metodo validate, que recibe como parametros el request
        luego coma, y se envia un arreglo de reglas, mediante 
            'nombre del control del campo' =>'regla a aplicar'
        En la vist adebe agregarse la directiva @error @enderror para que se muestre el mensaje, se relacionan por el campo
        Para el caso de que se quiera validar mas de una propiedad se usa el pipe
        se puede enviar el mensaje manualmente pero laravel ya tiene un array con estos en la variable $$message que se manda por blade a la vista
        Inicialmente estan en ingles por lo que habria que descargarlos eh instalarlos en la carpeta resources lang
        para instalarlo lo buscamos en inetrnet, utilizaremos uno de github de alguien identificado como laraveles
        hay que descargar el archivo en zip, y luego pasar el contenido de la carpeta resoruces/lang/es a nuestro proyecto igual en <resourses>
        Luego hay que cambiar el idioma de la aplicacion en : config/app.php y cambiar en la linea de "locale" a es

        Ahora bien para guardar los datos que tenia el campo en la vista se agrega en el atributo value del campo con la directiva old y el nombre del campo
        de este modo si hay un error recarga los datos ingresados, es importante que va entrecomillado

        <input 
                        id="name"
                        name= "name"
                        type="text"
                        placeholder="Tu nombre"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                        value="{{old('name')}}"
                     />
                     @error('name')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
        Tipos de validacion
        required = requerido
        max = maximo caracteres
        min = minimo caracteres
        unique clave unica, en caso de esta validacion hay que aregar el nombre de la tabla donde es unico en este caso tabla users
        */
       
 // Aqui una validación modificando el request, el instructor dice que no es conveniente pero igual lo enseño

        $request->request->add(['username'=> Str::slug($request->username)]);

        $this ->validate($request,[
            'name'=>'required|max:30',
            'username'=> 'required|unique:users|min:3|max:20',
            'email'=> 'required|unique:users|min:4|max:60|email',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required'
        ]);

       


        //dd("Si pasó validación".$request);
        /* Para poder crear registros o interactuar con la base de datos se usan modelos, estos modelos son utiklizado por el
        ORM que en laravel se llama Eloquent, y entonces el modelo tiene funciones especificas para la manipulación de registros
        Cada modelo solo inreactua con una tabla de la base de datos
        
        IMPORTANTE 
        Por default Eloquent considera que el modelo se escribe en singular y espera que la tabla se llame en pluralk
        por ejemplo para usuarios pues el modelo se llama user, y la tabla users

        Tambien es importante que se tiene que importar el modelo hasta arriba viene, para hacerlo se escribe el nombre y de las opciones se seleecciona addmodel

        */
        User::create([
            //Nombre_campo=>$objeto que tiene los datos -> atributo del objeto
            'name'=>$request->name,
            // ponerlo en minusculas con lower pero admite espacios usaremos slug para que elimine los espacios
           // 'username'=>Str::lower($request->username),
            // slug convierte el texto en una url, una vez que se ha establecido como unique  en la migración de la tabla ya no permite duplicados
            
            // esta linea la quito por que se modifico el request
            //'username'=>Str::slug($request->username),
            'username'=>$request->username,
            'email' =>$request->email,
            'password'=> Hash::make($request->password)
        ]);

        // Autentificación de usuario
        // auth es un helper de larabel y maneja las sesiones
        /*
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);
        */
        // otra forma de autenticar es la siguiente
        auth()->attempt($request->only('email','password'));
         // ruta normal
        //return redirect()->route('posts.index');
        // modificación para incluir parametro del usuario autenticado 
        return redirect()->route('posts.index', ['user' => auth()->user()->username]);
    }
}
