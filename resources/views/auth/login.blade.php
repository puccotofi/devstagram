@extends('layouts.app')
@section('titulo_pagina')
    Login en Devstagram
@endsection
@section('contenido')
    <div class="md:flex md:justify-center md:gap-10  md:items-center">
        <div class="md:w-4/12 p-5 rounded-3xl">
            <img src="{{asset('img/login.jpg')}}" class="rounded-2xl" alt="Imagen login de usuario">
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-lg">
            <form method="POST" action="{{route('login')}}" novalidate>
                @csrf
                @if (session('mensaje'))
                    <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">
                        {{session('mensaje')}}
                    </p>
                @endif
                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Correo Electrónico:
                    </label>
                    <input 
                        id="email"
                        name= "email"
                        type="email"
                        placeholder="Correo Electrónico"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{old('email')}}"
                     />
                     @error('email')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password:
                    </label>
                    <input 
                        id="password"
                        name= "password"
                        type="password"
                        placeholder="Password"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                        
                     />
                     @error('password')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                </div>
                
                <div class="mb-5">
                    <input type="checkbox" name="remember"> Mantener mi sesión abierta
                </div>
                <input 
                    type="submit"
                    value="Iniciar Sesion"
                    class="bg-sky-600 hover:border-s-sky-700 transition-colors
                    uppercase font-bold w-full p-3 text-white rounded-lg cursor-pointer"
                >
            </form>
            
        </div>
    </div>
@endsection