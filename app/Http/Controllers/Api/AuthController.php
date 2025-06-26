<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Регистрация пользователя.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Создаём пользователя
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // по умолчанию роль user
        ]);

        // Генерируем токен
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type'  => 'Bearer',
        ], 201);
    }

    /**
     * Логин пользователя.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Неверные учётные данные'
            ], 401);
        }

        // Удаляем старые токены (опционально)
        $user->tokens()->delete();

        // Создаём новый токен
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'accessToken' => $token,
            'token_type'  => 'Bearer',
        ]);
    }
}