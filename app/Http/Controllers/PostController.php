<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    function create(Request $request){
        $post = Post::create([
            'user_id' => 1,
            'post' => $request->get('post'),
           
        ]);
    }
}
