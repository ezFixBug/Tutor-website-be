<?php

use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\UserController;
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
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/provinces', [ProvinceController::class, 'getAllProvinces']);
Route::get('/districts/{province_id}', [ProvinceController::class, 'getDistrictByProvince']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [UserController::class, 'logout']);
});