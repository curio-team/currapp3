<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LeerlijnFactory extends Factory
{
    public function definition()
    {
        return [
            'naam' => strtoupper(fake()->lexify('???')),
        ];
    }
}
