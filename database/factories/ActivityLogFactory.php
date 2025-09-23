<?php

declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => \App\Models\Tenant::factory(),
            'user_id' => \App\Models\User::factory(),
            'subject_type' => null,
            'subject_id' => null,
            'level' => $this->faker->randomElement(\App\Enums\LogLevel::cases())->value,
            'type' => $this->faker->randomElement(\App\Enums\LogType::cases())->value,
            'action' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'metadata' => [
                'request_id' => $this->faker->uuid(),
                'correlation_id' => $this->faker->uuid(),
                'user_agent' => $this->faker->userAgent(),
                'ip_address' => $this->faker->ipv4(),
            ],
        ];
    }

    /**
     * Create an activity log for system actions (no user).
     */
    public function system(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => null,
            'type' => \App\Enums\LogType::SYSTEM->value,
        ]);
    }

    /**
     * Create an activity log for user actions.
     */
    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => \App\Enums\LogType::USER->value,
        ]);
    }

    /**
     * Create an activity log with a specific level.
     */
    public function level(\App\Enums\LogLevel $level): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => $level->value,
        ]);
    }
}
