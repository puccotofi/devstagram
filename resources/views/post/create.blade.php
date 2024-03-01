@extends('layouts.app')
@section('titulo')
    Crea una nueva publicacion
@endsection
@section('contenido')
    <div class="md:flex justify-center gap-10 items-center  bg-white rounded-lg ">
        <div class="md: w-1/2 px-10  ">
           
            <form id="dropzone" action="{{route('imagen.store')}}"  method="POST" enctype="multipart/form-data"
                                class="dropzone border-dashed border-2 w-full h-96 rounded
                                      flex flex-col justify-center items-center">
                                      @csrf
                                      
                                      
           </form>

        </div>
        <div class="md: w-1/2 px-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{route('post.store')}}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Titulo:
                    </label>
                    <input 
                        id="titulo"
                        name= "titulo"
                        type="text"
                        placeholder="Tu Titulo"
                        class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror"
                        value="{{old('titulo')}}"
                     />
                     @error('titulo')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                     <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripción
                    </label>
                     <textarea 
                        id="descripcion"
                        name= "descripcion"
                        placeholder="Descripción de la publicación"
                        class="text-gray-500 border p-3 w-full rounded-lg @error('descripcion') border-red-500 @enderror"
                        />{{old('descripcion')}}
                        </textarea>
                     @error('descripcion')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                    <!--Sección para incluir la imagen-->
                    <input type="hidden"
                            id="imagen"
                            name="imagen" 
                            value="{{old('imagen')}}">

                    @error('imagen')
                        <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                    @enderror

                        <input 
                        type="submit"
                        value="Crear Post"
                        class="bg-sky-600 hover:border-s-sky-700 transition-colors
                        uppercase font-bold w-full p-3 text-white rounded-lg cursor-pointer"
                        >
                </div>
                
            </form>
         </div>
    </div>
@endsection