<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Contribution;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    protected static ?string $community_id;
    protected static ?string $contribution_id;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'community_id' => static::$community_id ??= Community::factory()->create()->id,
            'contribution_id' => static::$contribution_id ??= Contribution::factory()->create()->id
        ];
    }
}
