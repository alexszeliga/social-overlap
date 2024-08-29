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
    protected static ?string $user_id;
    protected static ?string $conversation_id;
    protected static ?string $commentable_id;
    protected static ?string $commentable_type;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => static::$conversation_id ??= Conversation::factory()->create()->id,
            'user_id' => static::$user_id ??= User::factory()->create()->id,
            'commentable_id' => static::$commentable_id ??= Conversation::factory()->create()->id,
            'commentable_type' => static::$commentable_type ??= Conversation::class,
            'body' => fake()->text(),
        ];
    }
}
