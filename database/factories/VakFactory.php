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
        $name = fake()->word();
        return [
            'naam' => strtoupper(substr($name, 0, 3)),
            'omschrijving' => ucfirst($name),
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
