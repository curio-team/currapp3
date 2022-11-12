<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BlokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'naam' => 'Blok ' . ucfirst(fake()->unique()->randomLetter()),
            'volgorde' => fake()->randomDigit(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function zonderNaam()
    {
        return $this->state(fn (array $attributes) => [
            'naam' => null,
            'volgorde' => fake()->randomDigit(),
        ]);
    }
}
