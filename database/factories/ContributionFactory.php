<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Community;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contribution>
 */
class ContributionFactory extends Factory
{
    protected static ?string $user_id;
    protected static ?string $community_id;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => static::$user_id ??= User::factory()->create()->id,
            'community_id' => static::$community_id ??= Community::factory()->create()->id,
            'url' => 'https://google.com/'
        ];
    }
}
