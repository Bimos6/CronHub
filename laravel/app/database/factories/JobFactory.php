<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->url(),
            'method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE']),
            'cron_expression' => $this->faker->randomElement(['* * * * *', '*/5 * * * *', '*/30 * * * *']),
            'payload' => null,
            'headers' => null,
            'is_active' => true,
            'last_run_at' => null,
            'next_run_at' => now()->addMinutes($this->faker->numberBetween(1, 60)),
        ];;
    }

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => true,
            ];
        });
    }

    public function withPayload(array $payload)
    {
        return $this->state(function (array $attributes) use ($payload) {
            return [
                'payload' => json_encode($payload),
            ];
        });
    }

    public function withHeaders(array $headers)
    {
        return $this->state(function (array $attributes) use ($headers) {
            return [
                'headers' => json_encode($headers),
            ];
        });
    }

    public function ranRecently()
    {
        return $this->state(function (array $attributes) {
            return [
                'last_run_at' => now()->subMinutes(5),
            ];
        });
    }
}
