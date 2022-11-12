<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AcceptatiecriteriumFactory extends Factory
{
    public function definition()
    {
        return [
            'datum_start' => '2020-08-01',
            'tekst_kort' => fake()->sentence(3),
            'tekst_lang' => fake()->sentence(9),
        ];
    }
}
