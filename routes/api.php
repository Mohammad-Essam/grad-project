<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\social\PostController;
use App\Http\Controllers\social\CommentController;

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


//get the posts of the user friends.
Route::get('/posts', [PostController::class,'index']);
//post a new post
Route::post('/posts', [PostController::class,'store']);
//delete post
Route::delete('/posts/{post}', [PostController::class,'destroy']);

//likes end-points for posts
//like a post
Route::post('/posts/{post}/like', [PostController::class,'like']);
//unlike a post
Route::post('/posts/{post}/unlike', [PostController::class,'unLike']);
//get number of likes
Route::get('/posts/{post}/numberOfLikes', [PostController::class,'numberOfLikes']);


//comment end points
Route::get('/posts/{post}/comments', [CommentController::class,'index']);
Route::post('/posts/{post}/comments', [CommentController::class,'store']);


Route::get('/posts/{post:id}', [PostController::class,'show']);
//Route::post('/posts/{id}', [PostController::class,'update']);





// Route::post('/post/{postId}/comments/{commentId}', [CommentController::class,'update']);
// Route::delete('/post/{postId}/comments/{commentId}', [CommentController::class,'destroy']);
