<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * 

     *  Define the model's default state.
     *  Los factorys sirven para hacer purebas, laravel usa una libreria que se llama faker para ingresar daros
     *  Thinker es un CLI que trae integrado laravel y sirve para explorar db y ejecutar estas pruebas
     * Importante que al momento de usar el randomElement, este toma de los valores que se dan como arreglo de manera aleatoria 
     * en nuestro caso el elemento es el id de la relacio con usuario entonces deben existir esos registros o marca error
     * para ello usamos sail artisan thinker, 
     * Tambien es importante que una vez que sale un error hayq ue cerrar el tinker y abrirlo de nuevo o no cambia
     * 
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //definir los campos de la tabla que deseamos llenar, no se usa el id por que es autogenerado.
            'user_id'=>$this -> faker -> randomElement([2,3,4]),
            'titulo'=> $this -> faker -> sentence(5),
            'descripcion'=> $this -> faker->sentence(20),
            'imagen'=> $this -> faker -> uuid().'.jpg',
            
        ];
        /*
         
            //Ahora bien  para ejecutarlo hay que ir a una terminal  y usar thinker 
                 * 
        */
    }
}
