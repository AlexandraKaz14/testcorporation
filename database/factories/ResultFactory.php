<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\Variable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'test_id' => Test::factory(),
            'number'=>fake()->randomDigitNotNull(),
            'text' => fake()->sentence(4),
            'picture' => fake()->imageUrl(),
            'is_default'=> false,
            'condition' => fake()->randomElement(['>10', '==4', '<1', '+30', '-1']),
      ];

    }
}
