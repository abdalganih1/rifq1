<?php

namespace Database\Factories;

use App\Models\IndependentTeam;
use App\Models\Governorate;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndependentTeamFactory extends Factory
{
    protected $model = IndependentTeam::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'governorate_id' => Governorate::factory(),
            'contact_phone' => fake()->phoneNumber(),
        ];
    }
}
