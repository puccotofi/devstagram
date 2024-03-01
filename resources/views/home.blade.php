@extends('layouts.app')
@section('titulo_pagina')
    Titulo de Pagina de Inicio
@endsection
@section('contenido')
    Contenido de la Pagina
     <!--Pasamos los parametros Slots aqui, estos se ponen en el constructor del compronente
    para eso se usan los dos puntos y la sintaxis de despues
    en nuestro caso la variable es el listado de post que se crea en el controlador-->
       <x-listar-post :posts="$posts"/>
       
@endsection