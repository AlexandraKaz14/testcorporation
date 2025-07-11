<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\CustomAudit;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use App\Models\Variable;
use Aws\Result;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class CustomAuditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $auditableType = fake()->randomElement([
            Test::class, User::class, Answer::class, Question::class, Variable::class,
        ]);

        return [
            'user_id' => User::factory(),
            'user_type' => User::class,
            'event' => fake()->randomElement([CustomAudit::EVENT_RESTORED, CustomAudit::EVENT_CREATED, CustomAudit::EVENT_UPDATED, CustomAudit::EVENT_DELETED]),
            'auditable_type' => $auditableType,
            'auditable_id' => $auditableType::factory(),
            'old_values' => fake()->boolean(70) ? json_encode(['field' => fake()->word()]) : null,
            'new_values' => json_encode(['field' => fake()->word()]),
            'url' => fake()->url(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
