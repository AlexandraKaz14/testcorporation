<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TakingTest>
 */
class TakingTestFactory extends Factory
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
            'code' => Str::random(10),
            'ip_address' => $this->faker->ipv4,
            'request' => json_encode(['answers' => [$this->faker->randomDigitNotNull()]]),
            'generated_text_result' => $this->faker->sentence,
            'generated_picture_result' => $this->faker->imageUrl(),
            'is_temporary'=>false,
        ];
    }
}
