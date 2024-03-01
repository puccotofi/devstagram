@extends('layouts.app')

 <!--Emeplo de Route model Bindign
    Aqui por ejemplo este objeto variable $post llega desde dashboard, en el enlace, y en la ruta se indicó que se estaría enviando este dato
    de modo que eloquent me permite explotar esta información en directo sin tener que hacer mas consultas
-->
@section('titulo_pagina')

    {{$post->titulo}}
   
@endsection

@section('contenido')
    <div class="container mx-auto md:flex gap-4">
        <div class="md:w-1/2">
            <img src="{{asset('uploads').'/'.$post->imagen}}" alt="Imagen del Post {{$post->titulo}}">
            <div class="p-3 flex items-center">
                
                <p class="font-bold">
                    @if ($post->checkLike(auth()->user()))
                        <form method="POST" action="{{route('posts.like.destroy',$post)}}">
                            @method('DELETE')
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </div>
                        </form>  
                    @else
                        <form method="POST" action="{{route('posts.like.store',$post)}}">
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </button>
                            </div>
                        </form>    
                    @endif

                    {{$post->likes->count()}}
                    <span class="font-normal">Likes</span>
                </p>    
            </div>
            <div>
                <!--
                    Importante, aqui vemos como se explotan las relaciones que se definen en los modelos
                    en el modelo post se establecio una relacion con user, de modo que eloquent rescata esos datos
                    y asi podemos acceder a ellos sin tener una instanica propia del usuario

                    IMPORTANTE PARA MOSTRAR FECHAS LARAVEL TIENE diffForHumans() que formatea las fechas  que es una funcion
                    de una libreria que se llama CARBON que es una api para formatear las fechas

                -->
                <p class="font-bold">{{$post->user->username}}</p>
                <p class="text-gray-500 text-sm">{{$post->created_at->diffForHumans()}}</p>
                <p class="mt-5">{{$post->descripcion}}</p>
            </div>
            @auth
                @if ($post->user_id === auth()->user()->id)
                    <!--IMPORTANTE los navegadores no tienen metodo delete, asi que se usa 
                    el metodo spoofing, que es usar una directiva para poder utilizar otro metodos
                    Como vamos a hacer cambios en la db se debe agregar  la directiva
                    csrf para que use el token de autentificación-->
                    <form method="POST" action="{{route('posts.destroy', $post)}}">
                        @method('DELETE')
                        @csrf
                        <input 
                            type="submit"
                            value="Eliminar Publicacion"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white mt-4 cursor-pointer "
                        >
                    </form>        
                @endif
            @endauth
        </div>
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5"> 
                @auth
                <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p> 

                @if (session('mensaje'))
                    <div class="bg-green-500 text-white mb-5 rounded-lg text-center uppercase font-bold">
                        {{session('mensaje')}}
                    </div>
                @endif

                <form action="{{route('comentarios.store',['post'=>$post, 'user'=>$user])}}" method="POST">
                    @csrf
                     <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                         Coemntario
                     </label>
                     <textarea 
                         id="comentario"
                         name= "comentario"
                         placeholder="Comentario para la publicación"
                         class="text-gray-500 border p-3 w-full rounded-lg @error('Comentario') border-red-500 @enderror"
                         />{{old('comentario')}}
                         </textarea>
                     @error('comentario')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                     <input 
                         type="submit"
                         value="Comentar"
                         class="bg-sky-600 hover:border-s-sky-700 transition-colors
                         uppercase font-bold w-full p-3 text-white rounded-lg cursor-pointer"
                     >
                </form>
      
                @endauth
                <!--Aqui vamos a mostrar los comentarios -->
                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10 ">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario )
                            <div class=" p-5 border-gray-400 border-b ">
                                <a href="{{route('posts.index', $comentario->user)}}">
                                    {{$comentario->user->username}}
                                </a>
                                <p>{{$comentario->comentario}}</p>
                                <p class="text-gray-500 text-sm ">{{$comentario->created_at->diffForHumans()}}</p>
                            </div>
                        @endforeach
                    @else

                        <p class="p-10 text-center ">Sin Comentarios</p>
                        
                    @endif
                            
                </div>
            </div>
        </div>
    </div>
@endsection
