<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    // variable que viene desde la vista show.blade para pasar como varaible un post
    // al registrarla aqui ya estará accesible desde like-post-blade
    public $post;
    
    protected $listeners = ['like' => 'like'];
    public function render()
    {
        return view('livewire.like-post');
    }
    public function like(){
        return "desde funcion like wire";
    }
}
