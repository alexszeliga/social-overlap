<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\CommunityContribution;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected static ?string $user_id;
    protected static ?string $community_contribution_id;
    protected static ?string $commentable_id;
    protected static ?string $commentable_type;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $conversation_id = static::$community_contribution_id ??= CommunityContribution::factory()->create()->id;
        return [
            'community_contribution_id' => $conversation_id,
            'user_id' => static::$user_id ??= User::factory()->create()->id,
            'commentable_id' => static::$commentable_id ??= $conversation_id,
            'commentable_type' => static::$commentable_type ??= CommunityContribution::class,
            'body' => fake()->text(),
        ];
    }
}
