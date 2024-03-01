<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    public function store(Request $request, Post $post){
        // comprobando la conexion del endpoint
        //dd('dando like' .$post);
        $post->likes()->create([
            'user_id' => $request->user()->id,
            'post_id'=> $post->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post){
        // funcion para eliminar un like
        //dd('eliminando like' .$request);
        $request->user()->likes()->where('post_id',$post->id)->delete();

        return back();
    }
}
