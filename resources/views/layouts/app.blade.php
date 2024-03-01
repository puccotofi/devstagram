<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
      
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Esta directiva stacks es para reservar un espacio para cargar hojas de esitlo -->
        @stack('styles')
        @push('styles')
          <!-- Estilo para el control de dropzone   -->
          <!--<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />-->
        @endpush
        @livewireStyles
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
        <!-- <link href="{{asset('css/app.css')}}" rel="stylesheet">-->
        <title>Devstagram @yield('titulo_pagina')</title>
        <!-- Registramos tailwind   -->
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="bg-gray-300">
      
      
      <header  class="p-5 bg-white border-b shadow-lg">
        <div class="container mx-auto flex justify-between items-center">    
          <a class="text-3xl font-black" href="{{route('home')}}">
            Devstagram
          </a> 
          @auth
              <a class="font-bold text-gray-600 text-sm" href="{{route('posts.index', ['user' => auth()->user()->username])}}">
                Hola: <span class="font-normal"> {{auth()->user()->username}} </span>
              </a>  
          @endauth     
          
         <!--Sección de usuarios logueados con auth laravel hace la validacion-->
         @auth
          <nav class="flex gap-2 items-center">
            <a class="flex gap-2 items-center bg-white text-gray-600 text-sm border p-2 rounded-xl cursor-pointer uppercase font-bold mx-4"
             href="{{route('post.create')}}">

              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
              </svg>
                Crear
            </a>
            
            <form method="POST" action="{{route('logout')}}">
              @csrf
              <button type="submit" class="font-bold uppercasebg-white text-gray-600 text-sm border p-2 rounded-xl cursor-pointer uppercase  mx-4">
                  CERRAR SESIÓN    
              </button>
            </form>
            
          </nav> 
         @endauth
         <!--Sección de usuarios SIN REGISTRAR con guest laravel hace la validacion-->
         @guest
            <nav class="flex gap-2 items-center">
              <a class="font-bold uppercase text-gray-600 text-sm" href="{{route('login')}}">Iniciar Sesión</a>
              <a class="font-bold uppercase text-gray-600 text-sm" href="{{route('register')}}">Crear Cuenta</a>
            </nav> 
         @endguest
        </div>      
      </header>


      <main class="container mx-auto mt-10">
        <h2 class="font-black text-center text-3xl mb-10">
            @yield('titulo_pagina')
        </h2>
        
        @yield('contenido')

      </main>


      <footer class="text-center p-5 mt-10 uppercase font-bold text-gray-400">
          Devstagram Derechos reservados {{now()->year}}
      </footer>
    </body>
</html>
