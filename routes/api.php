<?php

use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilController;
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

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/become-tutor', [UserController::class, 'registTutor']);
});