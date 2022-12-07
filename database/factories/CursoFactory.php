<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Student;
use App\Models\Profesor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Curso>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nombre" => fake()->word(),
            "profesor" => Profesor::factory()->hasCurso(),
            'student' => Student::factory()->hasCurso(),
        ];
    }
}
