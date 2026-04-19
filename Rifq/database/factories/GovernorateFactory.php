<?php

namespace Database\Factories;

use App\Models\Governorate;
use Illuminate\Database\Eloquent\Factories\Factory;

class GovernorateFactory extends Factory
{
    protected $model = Governorate::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->city(),
        ];
    }
}
