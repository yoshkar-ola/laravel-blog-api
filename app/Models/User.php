<?php

namespace App\Models;

use App\Models\Post;                // ← импортируем Post
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Поля, разрешённые для массового заполнения.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Поля, скрытые в JSON-ответах.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * Автоматические приведения типов.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions'       => 'array',
    ];

    /**
     * Связь: пользователь может иметь много постов.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
