<?php

namespace Database\Factories;

use App\Enum\PostStatusEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $ids = User::pluck('id')->toArray();
        return [
            'title' => fake()->text(100),
            'slug' => fake()->slug(),
            'user_id' => fake()->randomElement(array_values($ids)),
            'description' => fake()->text(200),
            'content' => fake()->text(),
            'publish_date' => fake()->date('Y-m-d H:i:s'),
            'status' => fake()->randomElement(PostStatusEnum::cases()),
            'created_at' => fake()->date('Y-m-d H:i:s'),
            'updated_at' => fake()->date('Y-m-d H:i:s'),
        ];
    }

    protected $model = Post::class;
}