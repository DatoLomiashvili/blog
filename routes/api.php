<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogsController;
use App\Http\Controllers\Api\CommentsController;
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

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/refresh_token', [AuthController::class, 'refreshToken'])->name('auth.refreshToken');
});

Route::get('/whoami', [AuthController::class, 'whoami'])->name('whoami');

Route::middleware('auth:api')->prefix('blogs')->group(function () {
    Route::post('/', [BlogsController::class, 'getList'])->name('blogs.list');
    Route::get('/{id}', [BlogsController::class, 'getBlog'])->name('blogs.view');
    Route::post('/update/{id}', [BlogsController::class, 'updateBlog'])->name('blogs.update');
    Route::post('/create', [BlogsController::class, 'createBlog'])->name('blogs.create');
    Route::delete('/delete/{id}', [BlogsController::class, 'deleteBlog'])->name('blogs.delete');
});

Route::middleware('auth:api')->prefix('comments')->group(function () {
    Route::post('/create', [CommentsController::class, 'createComment'])->name('comments.create');
    Route::delete('/delete/{id}', [CommentsController::class, 'deleteComment'])->name('comments.delete');
});
