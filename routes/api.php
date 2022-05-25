<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\badges\BadgeController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\social\PostController;
use App\Http\Controllers\social\CommentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\training\ExerciseController;
use App\Http\Controllers\training\TrainingProgramController;
use App\Http\Controllers\training\RecordController;

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
//for testing purpose only
Route::post('/test',[TestController::class,'storeInPublic']);




//register, login and logout
Route::post('/register', [Authentication::class, 'register']);
Route::post('/login', [Authentication::class, 'login']);
Route::post('/logout', [Authentication::class, 'logout']);
Route::post('/update', [Authentication::class, 'updateAvatar']);


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

//get all usernames 
Route::get('/users',[UserController::class,'index']);



//Exercises end-points
Route::get('/exercises',[ExerciseController::class,'index']);
Route::get('/exercises/names',[ExerciseController::class,'exercisesNames']);
Route::post('/exercises',[ExerciseController::class,'store']);
Route::get('/exercises/{exercise:name}',[ExerciseController::class,'show']);



//Training programs end-points
//all information about programs
Route::get('/programs',[TrainingProgramController::class,'index']);

Route::post('/programs',[TrainingProgramController::class,'store'])->name('addProgram');

//training programs names
Route::get('/programs/names',[TrainingProgramController::class,'programsNames']);


//to get specefic workout
Route::get('/programs/{trainingProgram:name}',[TrainingProgramController::class,'show']);

//to put exercises on specefic program
//name  sets reps order day
Route::post('/programs/{trainingProgram}',[TrainingProgramController::class,'storeExercises']);


//to get specefic day workout
Route::get('/programs/{trainingProgram:name}/{day}',[TrainingProgramController::class,'day']);

Route::get('/records/exercises',[RecordController::class,'index']);
Route::post('/records/exercises',[RecordController::class,'store']);




Route::get('/badges',[BadgeController::class,'index']);
Route::post('/badges',[BadgeController::class,'store']);
Route::post('/badges/{name}',[BadgeController::class,'storeRule']);
Route::get('/badges/{name}',[BadgeController::class,'show']);
Route::post('/badges/{name}/share',[BadgeController::class,'share']);

Route::post('/badges/{name}/delete',[BadgeController::class,'destroy']);


//request a comptitation
Route::get('/challenges',[ChallengeController::class,'index']);
Route::get('/challenges/{challenge_id}',[ChallengeController::class,'show']);
Route::post('/challenges',[ChallengeController::class,'store']);
Route::post('/challenges/{challenge_id}/',[ChallengeController::class,'accept']);
Route::post('/challenges/{challenge_id}/increase',[ChallengeController::class,'increase']);
