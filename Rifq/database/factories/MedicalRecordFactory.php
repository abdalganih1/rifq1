<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalRecord>
 */
class MedicalRecordFactory extends Factory
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
            'vet_id' => \App\Models\User::factory(),
            'record_type' => fake()->randomElement(['Vaccination', 'Neutering', 'Treatment', 'Surgery']),
            'diagnosis' => fake()->sentence(),
            'treatment_given' => fake()->paragraph(),
            'visit_date' => fake()->date(),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
