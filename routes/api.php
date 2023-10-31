<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// User
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);

Route::get('/provinces', [ProvinceController::class, 'getAllProvinces']);
Route::get('/districts/{province_id}', [ProvinceController::class, 'getDistrictByProvince']);

Route::get('/subjects', [UtilController::class, 'getAllSubjects']);
Route::get('/classes', [UtilController::class, 'getAllClasses']);
Route::get('/jobs', [UtilController::class, 'getAllJobs']);

Route::get('/posts', [PostController::class,'getAllPosts']);
Route::get('/post/{post_id}', [PostController::class,'getPostDetail']);

Route::get('/comments/{relation_id}', [CommentController::class,'getComments']);

Route::get('/course/{course_id}', [CourseController::class,'getDetailCourse']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::post('/become-tutor', [UserController::class, 'registTutor']);

    //user's posts
    Route::get('/posts/{user_id}', [PostController::class,'getPostsByUser']);
    Route::post('/post/{user_id}', [PostController::class,'createPostByUser']);
    Route::post('/post/edit/{post_id}', [PostController::class,'editPost']);
    Route::delete('/post/{post_id}', [PostController::class,'deletePost']);

    // comment
    Route::post('/comment', [CommentController::class,'addComment']);

    //like
    Route::post('/like', [PostController::class, 'hanleLike']);
    
    //user's courses
    Route::post('/course/{user_id}', [CourseController::class,'createCourse']);
    Route::get('/courses/{user_id}', [CourseController::class,'getUserCourses']);
    Route::post('/edit-course', [CourseController::class,'editCourse']);
    Route::delete('/delete-course/{course_id}', [CourseController::class,'deleteCourse']);
});