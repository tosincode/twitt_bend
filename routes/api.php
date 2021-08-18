<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post("register", [UserController::class, 'register']);

Route::post("login", [UserController::class, 'authenticate']);

Route::post("post", [PostController::class, 'create']);
Route::get("getpost", [PostController::class, 'getpost']);
Route::post("like_post", [PostController::class, 'likepost']);


Route::get("user", [UserController::class, 'getAuthenticatedUser']);





