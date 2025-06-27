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

// Регистрация и логин
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Мои посты — до «show», чтобы не попало под {post}
    Route::get('posts/me',     [PostController::class, 'myPosts']);

    // Публичный список и детальная страница
    Route::get('posts',        [PostController::class, 'index']);
    Route::get('posts/{post}', [PostController::class, 'show']);

    // Создание, обновление, удаление
    Route::post('posts',                           [PostController::class, 'store']);
    Route::match(['put', 'patch'], 'posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}',                  [PostController::class, 'destroy']);

    // Текущий пользователь
    Route::get('user', function (Request $request) {
        return new UserResource($request->user());
    });
});
