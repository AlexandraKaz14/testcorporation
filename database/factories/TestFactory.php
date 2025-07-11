<?php

namespace Database\Factories;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(50),
            'user_id' => User::factory(),
            'theme_id' => Theme::factory(),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['title']);
            },
            'description' => fake()->paragraph,
            'picture' => fake()->imageUrl(),
            'status' => fake()->randomElement(['draft']),
            'meta_keywords'=>fake()->text(50),
            'meta_description'=>fake()->text(50),
        ];
    }
}
