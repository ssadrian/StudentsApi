<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Curso;
use App\Models\Profesor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profesor>
 */
class ProfesorFactory extends Factory
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
            "user" => Profesor::factory()->hasUser(1),
            "cursos" => Profesor::factory()->hasCursos(1)
        ];
    }
}
