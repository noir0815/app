<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'content'=>fake()->realText(100),
            'score'=>fake()->numberBetween(1,5),
            'restaurant_id'=>fake()->numberBetween(1,300),
            'user_id'=>fake()->numberBetween(1,30),
        ];
    }
}
