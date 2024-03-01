<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ImagenController extends Controller
{
    //
    public function store(Request $request){
        //return dd('desde imagenes controller');
       // $input = $request->all();
        $imagen = $request->file('file');

        // crear un nombre unico para el archivo, para eso se usa el helper STR y su funcion uuid que genera un identificador unico
        $nombreImagen = Str::uuid().".". $imagen->extension();

        // crear instancia de la Imagen
        $imagen_servidor = Image::make($imagen);
        // modificar el tamaño de la imagen
        $imagen_servidor ->fit(1000,1000);

        // Para guardar la Imagagen
        // crear un path
        $imagen_path = public_path('uploads').'/'.$nombreImagen;
        // guardar la imagen en el servidor
        $imagen_servidor ->save($imagen_path);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
