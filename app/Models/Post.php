<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // para que composer pueda guardar debemos agregar al modelo los campos que son fillables

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'imagen',
        
    ];

    // relaciones en laravel, las relaciones se manejan desde los modelos 
    // se pone el nombre del modelo en plural
    public function user()
    {
        //has many es la funcion para estableer relaciones de uno a muchos y se pasa como atributo el modelo y ::class
        // en este caso la relacion indica que un post pertenece a usuario
        // así mismo para no enviar todos los datos se puede indicar que campos queremos que regrese la relacion al momento de consultarla
        
        return $this->belongsTo(User::class)->select(['name','username']);
    }

    // Funcion para visualizar los comentarios, tambien será mendiante una relacion donde
    // un post tiene muchos comentarios la relacion será has many

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // relacion para los likes, esta relacion ademas constituye un metodo que los relaciona, de modo que al momento
    // de guardar el like, se relaciona con el modelo, el codigo abajo dice algo asi como:
    // esta instancia de post. tiene muchos de modelo likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // funcion para buscar si un usuario ya le dio like a la publicación 
    // este metodo utiliza la relacion que acabamos de crear 

    public function checkLike(User $user){
        /* esta funcion contains es como un where donde se le indica la columna y un valor*/
        return $this->likes->contains('user_id', $user->id);
    }
}
