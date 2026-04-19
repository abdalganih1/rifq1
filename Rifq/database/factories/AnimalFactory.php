<?php

namespace Database\Factories;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qr_code_hash' => \Illuminate\Support\Str::uuid()->toString(),
            'name' => fake()->optional()->firstName(),
            'species' => fake()->randomElement(['Dog', 'Cat', 'Bird', 'Rabbit']),
            'breed' => fake()->word(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'estimated_age' => fake()->numberBetween(1, 15),
            'status' => fake()->randomElement(['Stray', 'In_Shelter', 'Adopted', 'Available', 'Deceased']),
            'location_found' => fake()->optional()->address(),
            'organization_id' => \App\Models\Organization::factory(),
            'owner_id' => null,
        ];
    }
}
