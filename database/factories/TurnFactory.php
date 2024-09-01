<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Comment;
use App\Models\TurnType;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Turn>
 */
class TurnFactory extends Factory
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
            'turnable_id' => Comment::factory(),
            'turnable_type' => Comment::class,
            'turn_type_id' => TurnType::support()->id,
        ];
    }
}
