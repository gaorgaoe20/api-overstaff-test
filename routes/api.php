<?php

use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ProductController;
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
    return response()->json([
        'user' => $request->user(),
    ]);
});


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/products', [ProductController::class,  'index']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class,'store']);
    Route::delete('/cart/{product:id}/remove', [CartController::class,'destroy']);

});
