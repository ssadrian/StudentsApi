<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => fake()->firstName(),
            'apellidos' => fake()->unique()->lastName(),
            'dni' => fake()->randomLetter() . fake()->randomNumber(8) . fake()->randomLetter(),
            'curso' => fake()->word(),
        ];
    }
}
