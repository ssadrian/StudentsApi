<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        User::factory()->count(5)->create();
        Curso::factory()->count(5)->create();
//        Student::factory()->count(5)->create();
//        Profesor::factory()->count(5)->create();
    }
}
