<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\social\PostController;
use App\Http\Controllers\social\CommentController;
use App\Http\Controllers\UserController;

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

//register, login and logout
Route::post('/register', [Authentication::class, 'register']);
Route::post('/login', [Authentication::class, 'login']);
Route::post('/logout', [Authentication::class, 'logout']);


//get the posts of the user friends.
Route::get('/posts', [PostController::class,'index']);
//post a new post
Route::post('/posts', [PostController::class,'store']);
//delete post
Route::delete('/posts/{post:id}', [PostController::class,'destroy']);

//likes end-points for posts
//like a post
Route::post('/posts/{post:id}/like', [PostController::class,'like']);
//unlike a post
Route::post('/posts/{post:id}/unlike', [PostController::class,'unLike']);
//get number of likes
Route::get('/posts/{post:id}/numberOfLikes', [PostController::class,'numberOfLikes']);


//comment end points
Route::get('/posts/{post:id}/comments', [CommentController::class,'index']);
Route::post('/posts/{post:id}/comments', [CommentController::class,'store']);


Route::get('/posts/{post:id}', [PostController::class,'show']);
//Route::post('/posts/{id}', [PostController::class,'update']);

//users end-points
Route::get('/users/profile',[UserController::class,'myProfile']);
Route::get('/users/{user:username}',[UserController::class,'show']);
Route::post('/users/{user:username}/add-friend',[UserController::class,'addFriend']);
Route::post('/users/{user:username}/remove-friend',[UserController::class,'removeFriend']);

// Route::post('/post/{postId}/comments/{commentId}', [CommentController::class,'update']);
// Route::delete('/post/{postId}/comments/{commentId}', [CommentController::class,'destroy']);
