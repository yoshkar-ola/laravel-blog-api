<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Просматривать список постов могут все авторизованные.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Просмотреть конкретный пост может админ или его автор.
     */
    public function view(User $user, Post $post): bool
    {
        return $user->role === 'admin'
            || $user->id === $post->user_id;
    }

    /**
     * Создавать пост может любой авторизованный.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Обновлять пост может админ или его автор.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->role === 'admin'
            || $user->id === $post->user_id;
    }

    /**
     * Удалять пост может админ или его автор.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->role === 'admin'
            || $user->id === $post->user_id;
    }

    public function restore(User $user, Post $post): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return $user->role === 'admin';
    }
}
