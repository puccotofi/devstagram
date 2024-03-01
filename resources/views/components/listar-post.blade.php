<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama 
    2024 02 16 Esta es una vista creada para un componente 
        Se manda llamar desde app view/components , esta en particular desde Listar Post
        Para incluirlo en la vista final se hace mediante las etiquetas
        simbolo abrir etiqueta x-listar-post simbolo cerrar
        eñ x-nombre-en-minus es una convension de laravel asi lo cambia y reconoce como un componente
        Pueden recibir Parametros. pero se aplican desde el blade que invoca el componente y se le spone nombre
        esto para que aqui que es donde va la logica se puedan usar las variables
    -->
    @if ($posts->count())
    <!-- para iterar los resultados de publicaciones accedemos a la llave $posts que fue la que enviamos desde el controlador
    Y usamos la directiva foreach endforeach-->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 grid-rows-5">
        @foreach ($posts as $post )
            <div>
                <a href="{{route('post.show',['post'=>$post, 'user'=>$post->user])}}">
                    <img src="{{asset('uploads').'/'. $post->imagen}}" alt="Imagen del post {{$post->titulo}}"
                    class="rounded">
                </a>
            </div>
        @endforeach
    </div>
    <div class="my-10">
            <!-- mostrar paginacion se tiene que agregar la paginación al taiwind.config-js-->
            {{$posts->links()}}
    </div>
    @else
        <p class="text-gray-600 uppercase text-center text-sm font-bold"> No hay Posts </p>
    @endif
    
</div>