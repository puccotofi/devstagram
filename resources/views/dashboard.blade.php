@extends('layouts.app')
@section('titulo_pagina')
<!--Aqui estamos jalando la información del modelo, esta informacion la mando en la llave $user-->
    Perfil de: {{$user->username}}
    @if (session('mensaje'))
        <p class="bg-green-400 text-white text-sm my-2 rounded-lg p-2 text-center">
            {{session('mensaje')}}
        </p>
    @endif
@endsection
@section('contenido')
    <div class="flex justify-center">
      
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            
            <div class="w-6/12 px-5 rounded-lg">
                <img src="{{ 
                    $user->imagen? 
                     asset('perfiles/'.$user->imagen) :
                     asset('img/user.png')}}"
                     alt="Imagen Usuario">
            </div>
            <div class="md:w-8/12 lg: w-6/12 px-5 flex flex-col items-center py-10 md:py-10 md:items-start md:justify-center">
                
                <!--
                    Esta forma la usabamos para usar el helper auth para obtener los datos del usuario pero desde 
                    el controlador de dashboardcontroller estamos mandando todos los datos del usuaio en la variable $user

                    <p class="text-gray-700 text-2xl">{{auth()->user()->username}}</p>
                -->
                <p class="text-gray-700 text-2xl mt-5">{{$user->username}}</p>
                @auth
                    @if($user->id === auth()->user()->id)
                        <div class="">
                            <a class="flex gap-2 items-center bg-white hover:bg-gray-200 text-gray-600 text-sm border p-2 rounded-xl cursor-pointer uppercase font-bold mx-4"
                                href="{{route('perfil.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                                Editar Perfil
                            </a>
                        </div>
                    @endif
                @endauth
                <p class="text-gray-700 text-sm mb-3 font-bold">
                    {{$user->followers->count()}}
                    <span class="font-normal"> @choice('Seguidor|Seguidores',$user->followers->count()) </span>
                </p>
                <p class="text-gray-700 text-sm mb-3 font-bold">
                    {{$user->followings->count()}}
                    <span class="font-normal"> @choice('Seguido|Seguidos',$user->followings->count()) </span>
                    
                </p>
                <p class="text-gray-700 text-sm mb-3 font-bold">
                    {{$user->posts->count()}}
                    <span class="font-normal"> Post </span>
                </p>
                @auth
                    @if($user->id !== auth()->user()->id)
                        @if($user->siguiendo(auth()->user()))
                            <form 
                                action="{{route('users.unfollow', $user)}}"
                                method="POST">
                                @method('DELETE')
                                @csrf
                                    <div class="">
                                        <input type="submit"
                                                class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-sm font-bold cursor-pointer"
                                                value="DEJAR DE SEGUIR"
                                    >
                                    </div>
                                
                            
                            </form> 
                        @else
                        
                            <form 
                                action="{{route('users.follow', $user)}}"
                                method="POST">
                                @csrf
                                    <div class="">
                                        <input type="submit"
                                                class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-sm font-bold cursor-pointer"
                                                value="SEGUIR"
                                    >
                                    </div>               
                            </form>
                        @endif
                    @else
                        
                    @endif
                @endauth
            </div>


        </div>

    </div>
    <section class="container mx-auto mt-10">
        <h2 class=" text-4xl text-center font-black my-10">Publicaciones</h2>
        <x-listar-post :posts="$posts"/>
        
    </section>
@endsection