<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Можно ли просматривать список пользователей.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Можно ли просмотреть конкретного пользователя.
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Можно ли создавать пользователя.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Можно ли обновлять пользователя.
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Можно ли удалить пользователя.
     */
    public function delete(User $user, User $model): bool
    {
        // Предотвращаем удаление самого себя:
        if ($user->id === $model->id) {
            return false;
        }
        return $user->role === 'admin';
    }

    public function restore(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }
}
