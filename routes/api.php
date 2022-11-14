<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/userProfile', [AuthController::class, 'userProfile']);
Route::post('/verify-email', [AuthController::class, 'resendVerifyEmail']);

Route::group([
  'middleware' => 'isUser'
], function () {
    Route::controller(StudentController::class)->group(function () {
        Route::get('/students', 'index');
        Route::get('/student/{id}', 'show');
        Route::post('/student', 'store');
        Route::put('/student/{id}', 'update');
        Route::patch('/student/{id}', 'update');
        Route::get('/search','search');
        Route::delete('/student/{id}', 'delete')->middleware('isAdmin');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/user/{id}', 'show');
        Route::post('/user', 'store');
        Route::put('/user/{id}', 'update');
        Route::delete('/user/{id}', 'delete')->middleware('isAdmin');
        Route::patch('/user/{id}', 'updateStatus')->middleware('isAdmin');
    });
});
