<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Community;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommunityUser>
 */
class CommunityUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'community_id' => Community::factory(),
        ];
    }

}
