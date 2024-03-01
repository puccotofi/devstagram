<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relaciones en laravel, las relaciones se manejan desde los modelos 
    // se pone el nombre del modelo en plural
    public function posts()
    {
        //has many es la funcion para estableer relaciones de uno a muchos y se pasa como atributo el modelo y ::class
        return $this->hasMany(Post::class);
    }

    // relacion para usuario -> likes

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // funciones para almacenar a los usuarios que te siguen
    // este es un tipo de relacion que no cumple con las convenciones de laravel
    // ya que los campos en la tabla followers no son los mismos asi pues se requiere indicar 
    // a que tabla hace referencia la relacion y el modelo
    // y tambien se tienen que indicar los campos que sirven como pivote en la realavion belongs to many
    // en este caso los campos se llaman user id y followed id
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');

    }

    // determinar cuantos esta siguiendo el usuario de la sesion
    //se hace igual que la funcion de followers pero se invierten los campos para obtener la relacion de los seguidos
    public function followings(){
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // funcion para determinar si un usuario esta siguiendo a otro
    // para ello usarmos este modelo y la funcion de followers que se interará a modo de consulta
    // regresa un boolean 

    public function siguiendo(User $user){
        // esto ejecutaria la consulta mediante la relacion de followers
        // el metodo que tiene la relacion de contains y se le pasa como parametro el objeto usuario
        // y se indica el campo de busqueda
        return $this->followers->contains($user->id);

    }
}
