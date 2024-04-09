<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogsController;
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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/refresh_token', [AuthController::class, 'refreshToken'])->name('auth.refreshToken');
});

Route::get('/whoami', [AuthController::class, 'whoami'])->name('whoami');

Route::middleware('auth:api')->prefix('blogs')->group(function () {
    Route::post('/', [BlogsController::class, 'getList']);
    Route::get('/{id}', [BlogsController::class, 'getBlog']);
//    Route::post('/{item_id}', [ArticlesController::class, 'getArticle'])
//        ->where('item_id', '[0-9]+');
});
