<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Conversation;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'user_id' => User::factory(),
            'commentable_id' => Conversation::factory(),
            'commentable_type' => Conversation::class,
            'body' => fake()->text(),
        ];
    }
}
