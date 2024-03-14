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

// public Routes
route::post('/register', [UserController::class, 'register']);
route::post('/login', [UserController::class, 'login']);

// protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    route::post('/logout', [UserController::class, 'logout']);
    route::get('/logged_user', [UserController::class, 'logged_user']);
    route::get('/change_password', [UserController::class, 'change_password']);

});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
