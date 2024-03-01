@extends('layouts.app')
@section('titulo_pagina')
    Editar Perfil : {{auth()->user()->username}}
@endsection
@section('contenido')
    
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow-lg p-6">
            <form 
                class=" mt-10 md:mt-0"
                action="{{route('perfil.store')}}"
                method="POST"
                enctype="multipart/form-data">
            @csrf
            
                <div class="mb-5">
                    @if (session('mensaje'))
                        <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">
                            {{session('mensaje')}}
                        </p>
                    @endif
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre de Usuario:
                    </label>
                    <input 
                        id="username"
                        name= "username"
                        type="text"
                        placeholder="Tu nombre de Usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{auth()->user()->username}}"
                     />
                     @error('username')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                </div>
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
                        value="{{auth()->user()->email}}"
                     />
                     @error('email')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                </div>
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen de Perfil:
                    </label>
                    <input 
                        id="imagen"
                        name= "imagen"
                        type="file"
                        accept=".jpg, .jpeg, .png, .gif"
                        placeholder="Imagen de Perfil"
                        class="border p-3 w-full rounded-lg @error('imagen') border-red-500 @enderror"
                        value=""
                     />
                     @error('imagen')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                </div>

                
                <div class="mb-5">
                    <label for="password_nuevo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nuevo Password:
                    </label>
                    <input 
                        id="password_nuevo"
                        name= "password_nuevo"
                        type="password"
                        placeholder="Nuevo Password"
                        class="border p-3 w-full rounded-lg @error('password_nuevo') border-red-500 @enderror"
                        
                     />
                     @error('password_nuevo')
                         <p class="bg-red-500 text-white text-sm my-2 rounded-lg p-2 text-center">{{$message}}</p>
                     @enderror
                </div>
                <div class="mb-5">
                    <p>Para guardar cambios escriba aqui el password actual</p>
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                      Password Actual  :
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
                <input 
                    type="submit"
                    value="Guardar Cambios"
                    class="bg-sky-600 hover:border-s-sky-700 transition-colors
                    uppercase font-bold w-full p-3 text-white rounded-lg cursor-pointer"
                >
            </form>

        </div>

    </div>

@endsection