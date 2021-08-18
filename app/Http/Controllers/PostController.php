<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PostController extends Controller
{
    function create(Request $request){
       $users = JWTAuth::user();

       


        $post = Post::create([
            'user_id' => $request->get('user_id'),
            'name' => $request->get('user_name'),
            'post' => $request->get('post'),
             
        ]);

      

        return response()->json([
            
            'message' => 'Successful'
          ], 200);
    }


    function getpost(){

        $post = Post::all();
        //return $post;

        return response()->json([
            'post' => $post,
            'message' => 'Successful'
          ], 200);
    }


    function likepost(Request $request){
        

        $likepost = Post::find($request->get('post_id'));

        $likepost->like_post = $likepost->like_post + 1;
        
        $likepost->save();
      
        return response()->json([
            
            'message' => 'Successful'
          ], 200);

    }
    
}
