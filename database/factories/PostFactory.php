<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
          'user_id'    => User::factory(),
          'title'      => $this->faker->sentence,
          'text'       => $this->faker->paragraph,
          'created_at' => now(),
          'updated_at' => now(),
        ];
    }
}
