<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\PostRequest;

class ApiPost extends Controller
{
    public function create(Request $request){

        $post = new Post;
        
        $post->user_id = Auth::guard('api')->user()->id;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->iframe = $request->iframe;

        //Check if post has photo
        if($request->photo != ''){
            //Choose a unique name for photo
            $photo = time().'jpg';
            file_put_contents('storage/posts/'.$photo,base64_decode($request->photo));
            $post->image = $photo;
        }
        
        $post->save();
        $post->user;
        return response()->json([
            'success' => true,
            'message' => 'Post agregado correctamente',
            'post' => $post,
        ]);
    }

    public function update(Request $request){

    }
}
