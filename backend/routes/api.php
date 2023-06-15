<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;

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


    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/sendResetPasswordLink', [AuthController::class, 'sendResetPasswordLink']);
    Route::post('/ResetPassword', [AuthController::class, 'ResetPassword']);


    Route::middleware('jwt.verify')->group(function() {
        Route::post('/addBlog', [BlogsController::class, 'addBlog']);
    Route::get('/allBlogs', [BlogsController::class, 'allBlogs']);
    Route::get('/myBlogs', [BlogsController::class, 'myBlogs']);
    Route::post('/blogDetails', [BlogsController::class, 'blogDetails']);
    Route::post('/blogEdit', [BlogsController::class, 'blogEdit']);
    Route::post('/updateBlog', [BlogsController::class, 'updateBlog']);
    Route::post('/blogDelete', [BlogsController::class, 'blogDelete']);
    Route::post('/likeMe', [BlogsController::class, 'likeMe']);

});
