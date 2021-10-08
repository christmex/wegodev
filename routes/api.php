<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::GET('/users', [UserController::class,'index']);
Route::POST('/users', [UserController::class,'store']);
Route::GET('/users/{srtUser}', [UserController::class,'show']);
Route::GET('/users/{srtUser}/rents', [UserController::class,'show_rents']);
Route::PUT('/users/{srtUser}', [UserController::class,'update']);
Route::DELETE('/users/{srtUser}', [UserController::class,'destroy']);

Route::GET('/books', [BookController::class,'index']);
Route::POST('/books', [BookController::class,'store']);

Route::POST('/rents', [RentController::class,'store']);