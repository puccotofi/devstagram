<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListarPost extends Component
{
    /**
     * en este constructor se recibe la variable que se utilizará en en el componente
     * se tienen que llamar igual las variables en todos lados para que laravel pueda mapear
     * si no se llaman igual no se puede ejecutar
     */
    public $posts;
    public function __construct($posts)
    {
        $this->posts=$posts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.listar-post');
    }
}
