<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\social\PostController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//register, login and logout
Route::post('/register', [Authentication::class, 'register']);
Route::post('/login', [Authentication::class, 'login']);
Route::post('/logout', [Authentication::class, 'logout']);

//
Route::get('/posts', [PostController::class,'index']);
Route::get('/posts/{id}', [PostController::class,'show']);
Route::post('/posts', [PostController::class,'store']);
Route::post('/posts/{id}', [PostController::class,'update']);
Route::delete('/posts', [PostController::class,'destroy']);
//likes end-points for posts
Route::post('/post/{id}/likes', [PostController::class,'like']);
Route::delete('/post/{id}/likes', [PostController::class,'unlike']);
Route::get('/post/{id}/likesNumber', [PostController::class,'numberOfLikes']);



//comment end points
Route::get('/post/{id}/comments', [CommentController::class,'index']);
Route::post('/post/{id}/comments', [CommentController::class,'store']);
Route::post('/post/{postId}/comments/{commentId}', [CommentController::class,'update']);
Route::delete('/post/{postId}/comments/{commentId}', [CommentController::class,'destroy']);
