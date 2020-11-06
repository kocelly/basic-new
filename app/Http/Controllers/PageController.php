<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{

    //metodo para listar todos los posts
    public function posts(){
        return view('posts', [
            'posts' => Post::with('user')->latest()->paginate()
        ]);
    }

    //retorna un solo post
    public function post(Post $post)
    {
        return view ('post', ['post' => $post]);
    }
}
