<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Insert New User
Route::post('/user', [UserController::class, 'insert']);
//Update User
Route::put('/user', [UserController::class, 'update']);
//Delete User
Route::delete('/user', [UserController::class, 'delete']);
//List User
Route::get('/user', [UserController::class, 'show']);
//User Login
Route::post('/login', [UserController::class, 'login']);
