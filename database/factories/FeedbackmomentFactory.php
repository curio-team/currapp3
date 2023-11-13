<?php

namespace Database\Factories;

use App\Models\Feedbackmoment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedbackmoment>
 */
class FeedbackmomentFactory extends Factory
{
    private $batchCodes = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => Feedbackmoment::generateCode($this->batchCodes),
            'naam' => fake()->sentence(3),
            'points' => fake()->numberBetween(1, 10),
            'cesuur' => fake()->numberBetween(70, 100),
            'checks' => fake()->sentence(10),
        ];
    }
}
