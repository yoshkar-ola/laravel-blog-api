<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_and_receive_token()
    {
        $payload = [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $response = $this->postJson('/api/register', $payload);
        $response->assertStatus(201)
                 ->assertJsonStructure(['accessToken','token_type']);
        $this->assertDatabaseHas('users',['email' => 'test@example.com']);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('mypassword')
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'mypassword',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['accessToken','token_type']);
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Неверные учётные данные']);
    }
}
