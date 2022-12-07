<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Curso;
use App\Models\Student;
use App\Models\Profesor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::insert(/** @lang MySQL */
            "INSERT INTO studentsapi.roles (nombre) VALUES (?), (?), (?), (?)",
            ["Admin", "Role1", "Role2", "Role3"]);

        Student::factory()->count(5)->create();
        Profesor::factory()->count(5)->create();
        Curso::factory()->count(5)->create();
    }
}
