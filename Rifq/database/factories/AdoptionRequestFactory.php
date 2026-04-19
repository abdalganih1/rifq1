<?php

namespace Database\Factories;

use App\Models\AdoptionRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AdoptionRequest>
 */
class AdoptionRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'animal_id' => \App\Models\Animal::factory(),
            'adopter_id' => \App\Models\User::factory(),
            'status' => fake()->randomElement(['Pending', 'Approved', 'Rejected']),
            'request_message' => fake()->paragraph(),
            'rejection_reason' => fake()->optional()->sentence(),
            'request_date' => fake()->dateTime(),
            'decision_date' => fake()->optional()->dateTime(),
        ];
    }
}
