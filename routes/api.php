<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function(){
    Route::post('signin', [AuthController::class, 'signIn']);
    Route::post('signup', [AuthController::class, 'signUp']);
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('book-stores', BookStoreController::class);
});
