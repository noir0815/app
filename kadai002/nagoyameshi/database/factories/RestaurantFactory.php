<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>fake()->realText(10),
            'description'=>fake()->realText(100),
            'price'=>fake()->randomNumber(5),
            'postal_code'=>fake()->postcode(),
            'address'=>fake()->address(),
            'phone_number'=>fake()->phoneNumber(),
            'category_id'=>fake()->numberBetween(1, 31)
        ];
    }
}
