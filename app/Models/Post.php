<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
    ];

    /**
     * Основное отношение: автор поста.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Псевдо-отношение user для фабрики.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
