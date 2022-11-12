<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class VakFactory extends Factory
{
    public function definition()
    {
        return [
            'naam' => strtoupper(fake()->lexify('???')),
            'omschrijving' => ucfirst(fake()->word()),
            'volgorde' => fake()->randomDigit(),
        ];
    }

    public function zonderOmschrijving()
    {
        return $this->state(fn (array $attributes) => [
            'omschrijving' => null,
        ]);
    }
}
