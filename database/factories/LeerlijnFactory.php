<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeerlijnFactory extends Factory
{
    public function definition(): array
    {
        return [
            'naam' => strtoupper(fake()->lexify('???')),
            'color' => fake()->hexColor(),
        ];
    }
}
