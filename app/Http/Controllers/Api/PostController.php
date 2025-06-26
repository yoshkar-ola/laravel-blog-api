<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // Все методы требуют аутентификации через Sanctum:
        $this->middleware('auth:sanctum');

        // Привязываем методы контроллера к методам PostPolicy:
        // index→viewAny, show→view, store→create, update→update, destroy→delete
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * GET /api/posts
     * Пагинированный список всех постов (viewAny).
     */
    public function index(Request $request)
    {
        $query = Post::with('author');

        if ($request->get('sort') === 'title') {
            $query->orderBy('title');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $posts = $query->paginate($request->get('limit', 10));

        // Возвращаем коллекцию PostResource с meta->pagination
        return PostResource::collection($posts);
    }

    /**
     * GET /api/posts/{post}
     * Детальная страница поста (view).
     */
    public function show(Post $post)
    {
        return new PostResource($post->load('author'));
    }

    /**
     * GET /api/posts/me
     * Мои посты (viewAny вручную).
     */
    public function myPosts(Request $request)
    {
        $this->authorize('viewAny', Post::class);

        $posts = $request->user()
                         ->posts()
                         ->with('author')
                         ->orderBy('created_at', 'desc')
                         ->paginate($request->get('limit', 10));

        return PostResource::collection($posts);
    }

    /**
     * POST /api/posts
     * Создание поста (create).
     */
    public function store(StorePostRequest $request)
    {
        $post = $request->user()
                        ->posts()
                        ->create($request->validated());

        return (new PostResource($post->load('author')))
               ->response()
               ->setStatusCode(201);
    }

    /**
     * PUT/PATCH /api/posts/{post}
     * Обновление поста (update).
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return new PostResource($post->load('author'));
    }

    /**
     * DELETE /api/posts/{post}
     * Удаление поста (delete).
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}