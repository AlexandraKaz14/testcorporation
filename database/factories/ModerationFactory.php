<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class ModerationFactory extends Factory
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
            'moderator_id'=>User::factory(),
            'moderation_status'=>fake()->randomElement(['pending','approved','rejected']),
            'rejection_reason' => fake()->sentence(4),
            'moderation_at'=>null,
        ];
    }
}
