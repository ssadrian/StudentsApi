<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentsController;

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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('students', [StudentsController::class, 'getAll']);
    Route::get('student', [StudentsController::class, 'get']);
    Route::post('student', [StudentsController::class, 'post']);
    Route::put('student', [StudentsController::class, 'put']);
    Route::delete('student', [StudentsController::class, 'delete']);

    Route::get('user', fn(Request $request) => $request->user());
});
