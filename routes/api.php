<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Публичный список и детальная страница
    Route::get('posts',         [PostController::class, 'index']);
    Route::get('posts/{post}',  [PostController::class, 'show']);

    // Мои посты
    Route::get('posts/me',      [PostController::class, 'myPosts']);

    // Создание, обновление, удаление
    Route::post('posts',        [PostController::class, 'store']);
    Route::match(['put', 'patch'], 'posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);

    // Текущий пользователь через ресурс
    Route::get('user', function (Request $request) {
        return new UserResource($request->user());
    });
});
