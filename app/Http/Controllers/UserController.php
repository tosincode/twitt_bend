<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;

use App\Mail\welcomEmail;


class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

         //return ["result" => $token];

        //$response = ["message" =>  $message];
        // return response()->json([
        //     "result" => $token,
        //     'message' => 'Successful'
        //   ], 200);

        return response()->json([
            "result" => $token,
            'message' => 'Successful'
          ], 200);
        
       // return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        //     $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        // if($validator->fails()){
        //         return response()->json($validator->errors()->toJson(), 400);
        // }


        $string = $request->get('email');

        $arr = explode("@", $string, 2);
        $name = $arr[0];

        $user = User::create([
            'name' => $name,
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        $details = [
            'title' => 'Congratulations',
            'body' => 'You are welcome to Twitee'
        ];

     

        Mail::to('faloduntosin0@gmail.com')->send(new welcomEmail($details));
       
      
       
       

        return response()->json([
                "result" => $token,
                'message' => 'Successful'
              ], 200);
    }

    public function getAuthenticatedUser()
        {
                try {

                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }

                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                        return response()->json(['token_expired'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());

                }

                return response()->json(compact('user'));
        }
}