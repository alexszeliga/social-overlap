<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TurnType>
 */
class TurnTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Support',
            'value' => 1
        ];
    }

    public function support(): static
    {
        return $this->state(fn(array $attr)=>[
            'name' => 'Support',
            'value' => 1,
        ]);
    }

    public function dissent(): static
    {
        return $this->state(fn(array $attr)=>[
            'name' => 'Dissent',
            'value' => -1,
        ]);
    }
}
