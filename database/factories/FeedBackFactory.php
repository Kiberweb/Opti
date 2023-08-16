<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedBack>
 */
class FeedBackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->firstName($gender = null|'male'|'female') . ' ' . $this->faker->lastName(),
            'phone' => $this->faker->phoneNumber(),
            'city_id' => $this->faker->biasedNumberBetween(1, 27),
            'feedback' => $this->faker->sentence(255),
        ];
    }
}
