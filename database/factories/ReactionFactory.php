<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Test;
use App\Models\Variable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reaction>
 */
class ReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'answer_id' => Answer::factory(),
            'variable_id'=>Variable::factory(),
            'value' => fake()->randomFloat(2, 0, 100),
            'operation' => fake()->randomElement(['addition', 'subtraction', 'multiplication', 'division',]),
        ];
    }
}
