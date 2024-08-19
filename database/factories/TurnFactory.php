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
    protected static ?string $user_id;
    protected static ?string $turn_type_id;
    protected static ?string $turnable_id;
    protected static ?string $turnable_type;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => static::$user_id ??= User::factory()->create()->id,
            'turnable_id' => static::$turnable_id ??= Comment::factory()->create()->id,
            'turnable_type' => static::$turnable_type ??= Comment::class,
            'turn_type_id' => static::$turn_type_id ??= TurnType::factory()->support()->create()->id,
        ];
    }
}
