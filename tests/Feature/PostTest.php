<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // создаём обычного юзера и берём ему токен
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('api')->plainTextToken;
    }

    /** @test */
    public function guest_cannot_access_posts()
    {
        $this->getJson('/api/posts')
             ->assertStatus(401);
    }

    /** @test */
    public function user_can_create_and_view_post()
    {
        $payload = ['title'=>'Hello','text'=>'World'];

        // создаём
        $create = $this->postJson('/api/posts', $payload, [
            'Authorization' => "Bearer {$this->token}"
        ]);
        $create->assertStatus(201)
               ->assertJsonPath('data.title', 'Hello');

        $id = $create->json('data.id');

        // читаем
        $this->getJson("/api/posts/{$id}", [
            'Authorization' => "Bearer {$this->token}"
        ])->assertStatus(200)
          ->assertJsonPath('data.text', 'World');
    }

    /** @test */
    public function user_cannot_update_others_post()
    {
        $other = User::factory()->create();
        $post  = Post::factory()->for($other)->create();

        $this->putJson("/api/posts/{$post->id}", [
            'title'=>'X','text'=>'Y'
        ], ['Authorization'=>"Bearer {$this->token}"])
             ->assertStatus(403);
    }

    /** @test */
    public function author_can_update_and_delete_own_post()
    {
        $post = Post::factory()->for($this->user)->create();

        $this->putJson("/api/posts/{$post->id}", [
            'title'=>'New','text'=>'Text'
        ], ['Authorization'=>"Bearer {$this->token}"])
             ->assertStatus(200)
             ->assertJsonPath('data.title','New');

        $this->deleteJson("/api/posts/{$post->id}", [],
            ['Authorization'=>"Bearer {$this->token}"])
             ->assertStatus(204);
    }
}
