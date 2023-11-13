<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RequestTutorController;
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
Route::get('/tutors', [UserController::class, 'getListTutor']);

Route::get('/provinces', [ProvinceController::class, 'getAllProvinces']);
Route::get('/districts/{province_id}', [ProvinceController::class, 'getDistrictByProvince']);

Route::get('/subjects', [UtilController::class, 'getAllSubjects']);
Route::get('/classes', [UtilController::class, 'getAllClasses']);
Route::get('/jobs', [UtilController::class, 'getAllJobs']);

Route::get('/posts', [PostController::class, 'getAllPosts']);
Route::get('/post/{post_id}', [PostController::class, 'getPostDetail']);

Route::get('/comments/{relation_id}', [CommentController::class, 'getComments']);

Route::get('/feedbacks', [FeedBackController::class, 'getAllFeedback']);

Route::get('/course/{course_id}', [CourseController::class, 'getDetailCourse']);
Route::get('/courses', [CourseController::class, 'getCourses']);

Route::get('/requests', [RequestTutorController::class, 'getRequests']);
Route::get('/detail-request/{request_id}', [RequestTutorController::class, 'getDetailRequest']);

// admin login
Route::post('/admin/login', [AdminController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::post('/become-tutor', [UserController::class, 'registTutor']);

    Route::get('/liked/{user_id}', [UtilController::class, 'getLiked']);

    //user's posts
    Route::get('/posts/{user_id}', [PostController::class, 'getPostsByUser']);
    Route::post('/post/{user_id}', [PostController::class, 'createPostByUser']);
    Route::post('/post/edit/{post_id}', [PostController::class, 'editPost']);
    Route::delete('/post/{post_id}', [PostController::class, 'deletePost']);

    // comment
    Route::post('/comment', [CommentController::class, 'addComment']);

    //like
    Route::post('/like/post', [PostController::class, 'hanleLike']);

    //user's courses
    Route::post('/course/{user_id}', [CourseController::class, 'createCourse']);
    Route::get('/courses/{user_id}', [CourseController::class, 'getUserCourses']);
    Route::post('/edit-course', [CourseController::class, 'editCourse']);
    Route::delete('/delete-course/{course_id}', [CourseController::class, 'deleteCourse']);
    Route::post('/like/course', [CourseController::class, 'hanleLike']);
    Route::post('/register/course', [CourseController::class, 'registerCourse']);
    Route::post('/approve/course/{register_course_id}', [CourseController::class, 'approveCourse']);
    Route::get('/register/course/{course_id}', [CourseController::class, 'getRegisterCourses']);
    Route::get('/course/students/{course_id}', [CourseController::class, 'getStudents']);

    //feedback 
    Route::post('/feedback', [FeedBackController::class, 'addFeedBack']);

    //request tutors
    Route::post('/request-tutor', [RequestTutorController::class, 'createRequest']);
    Route::get('/request-tutors/{user_id}', [RequestTutorController::class, 'getRequestOfUser']);
    Route::get('/offer-requests/{request_id}', [RequestTutorController::class, 'getOfferOfRequest']);
    Route::delete('/delete-request/{request_id}', [RequestTutorController::class, 'deleteRequest']);
    Route::post('/offer-request/{request_id}', [RequestTutorController::class, 'createOfferRequest']);
    Route::delete('/cancel-offer/{request_id}', [RequestTutorController::class, 'cancelOffer']);
    Route::post('approve-offer/{request_id}', [RequestTutorController::class, 'approveOffer']);
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::group(['prefix' => 'admin'], function(){
        Route::get('/tutors', [AdminController::class,'getTutors']);
        Route::post('/approve/tutor/{user_id}', [AdminController::class,'approveRequestTutor']);

        Route::get('/courses', [AdminController::class,'getCourses']);
        Route::post('/approve/course/{courser_id}', [AdminController::class,'approveCourse']);
    });
});