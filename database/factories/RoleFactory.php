<?php

namespace Database\Factories;

use App\Models\RoleNames;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nombre" => fake()->randomElement([
                RoleNames::Admin, RoleNames::Role1,
                RoleNames::Role2, RoleNames::Role3
            ])
        ];
    }
}
