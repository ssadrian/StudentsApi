<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Student;
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
            "nombre" => fake()->firstName(),
            "apellidos" => fake()->lastName(),
            "dni" => fake()->bothify("?########?"),
            "user" => Student::factory()->hasUser(1),
            "cursos" => Student::factory()->hasCursos(1)
        ];
    }
}
