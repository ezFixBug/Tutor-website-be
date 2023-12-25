<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RequestTutorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
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
Route::group(['prefix' => 'user'], function () {
    Route::group(['prefix' => '{id}'], function () {
        Route::get('/', [UserController::class, 'getUserById']);
        Route::group(['prefix' => 'rating'], function () {
            Route::post('/', [RatingController::class, 'createRatingTutor']);
        });
    });
});
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

Route::get('/courses', [CourseController::class, 'getCourses']);

Route::group(['prefix' => 'course'], function () {
    Route::group(['prefix' => '{course_id}'], function () {
        Route::get('/', [CourseController::class, 'getDetailCourse']);
        Route::group(['prefix' => 'rating'], function () {
            Route::post('/', [RatingController::class, 'createRatingCourse']);
        });
    });
});

Route::get('/requests', [RequestTutorController::class, 'getRequests']);
Route::get('/detail-request/{request_id}', [RequestTutorController::class, 'getDetailRequest']);

Route::get('/courses-registed/{user_id}', [CourseController::class, 'getCoursesRegisted']);
Route::get('/requested/{user_id}', [RequestTutorController::class, 'getRequested']);

Route::get('/student/request', [RequestTutorController::class, 'getOfferStudent']);
Route::post('/student/request', [RequestTutorController::class, 'approveOfferStudent']);


    //feedback 
    Route::post('/feedback', [FeedBackController::class, 'addFeedBack']);

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


    //request tutors
    Route::post('/request-tutor', [RequestTutorController::class, 'createRequest']);
    Route::get('/request-tutors/{user_id}', [RequestTutorController::class, 'getRequestOfUser']);
    Route::get('/offer-detail/{id}', [RequestTutorController::class, 'getOfferDetail']);
    Route::get('/offer-requests/{request_id}', [RequestTutorController::class, 'getOfferOfRequest']);
    Route::delete('/delete-request/{request_id}', [RequestTutorController::class, 'deleteRequest']);
    Route::post('/offer-request/{request_id}', [RequestTutorController::class, 'createOfferRequest']);
    Route::delete('/cancel-offer/{request_id}', [RequestTutorController::class, 'cancelOffer']);
    Route::post('approve-offer/{request_id}', [RequestTutorController::class, 'approveOffer']);


    Route::prefix('payment')->group(function () {
        // Route::prefix('users')->group(function () {
        //     Route::post('/intents', 'StripleController@paymentIntents');
        //     Route::patch('/intents', 'StripleController@updatePaymentIntents');
        //     Route::post('/setup_intents', 'StripleController@setupIntents');
        //     Route::prefix('methods')->group(function () {
        //         Route::get('/', 'StripleController@getPaymentMethods');
        //     });
        // });
        Route::post('/create', [PaymentController::class, 'createPayment']);
        Route::get('/histories', [PaymentController::class, 'getHistories']);
    });

    Route::post('/vn-pay', [PaymentController::class, 'getVnPayment']);
    Route::post('/momo-payment', [PaymentController::class, 'getMomoPayment']);

    Route::group(['prefix' => 'coupons'], function () {
        Route::get('/{code}', [CouponController::class, 'getCouponByCode']);
    });
});

Route::group(['middleware' => ['auth:admin']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/tutors', [AdminController::class, 'getTutors']);
        Route::post('/approve/tutor/{user_id}', [AdminController::class, 'approveRequestTutor']);

        Route::get('/courses', [AdminController::class, 'getCourses']);
        Route::post('/approve/course/{courser_id}', [AdminController::class, 'approveCourse']);

        Route::get('/statistics', [AdminController::class, 'getStatistics']);

        Route::group(['prefix' => 'coupons'], function () {
            Route::get('/', [CouponController::class, 'getList']);
            Route::post('/create', [CouponController::class, 'create']);
            Route::prefix('{id}')->group(function () {
                Route::get('/', [CouponController::class, 'show']);
                Route::post('/', [CouponController::class, 'update']);
                Route::delete('/', [CouponController::class, 'delete']);
            });
        });
    });
});
