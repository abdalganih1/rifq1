<?php

namespace Database\Factories;

use App\Models\AIScan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AIScan>
 */
class AIScanFactory extends Factory
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
            'user_id' => \App\Models\User::factory(),
            'scan_type' => fake()->randomElement(['Skin_Disease', 'Behavioral']),
            'media_url' => fake()->url(),
            'ai_prediction' => fake()->word(),
            'confidence_score' => fake()->randomFloat(2, 0, 100),
            'scan_date' => fake()->dateTime(),
        ];
    }
}
