<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Console\Application;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;

/**
 * Controller in charge with the C.R.U.D. of Students
 *
 * @see Student
 */
class StudentsController extends Controller
{
    /**
     * Get all Students from the DB
     *
     * @return Collection A collection of Student
     * @see Student
     */
    public function getAll(): Collection
    {
        return Student::with(["role", "cursos"])->get();
    }

    /**
     * Get a filtered student based on the body of the request
     *
     * @param Request $request The incoming request to the endpoint
     * @return JsonResponse A JsonResponse with all the filtered students<p>
     * If no filter was specified then returns all the students
     *
     * @see Student
     */
    public function get(Request $request): JsonResponse
    {
        $data = $request->validate([
            "id" => "nullable|int",
            "nombre" => "nullable|string",
            "apellidos" => "nullable|string",
            "dni" => "nullable|string",
            "curso" => "nullable|string"
        ]);

        $students = $this->getAll();

        if (isset($data["id"])) {
            $students = $students->where("id", $data["id"]);
        }

        if (isset($data["nombre"])) {
            $students = $students->where("nombre", $data["nombre"]);
        }

        if (isset($data["apellidos"])) {
            $students = $students->where("apellidos", $data["apellidos"]);
        }

        if (isset($data["dni"])) {
            $students = $students->where("dni", $data["dni"]);
        }

        if (isset($data["curso"])) {
            $students = $students->where("curso", $data["curso"]);
        }

        return response()->json(
            $students
        );
    }

    /**
     * Create a new student
     *
     * @param Request $request The incoming request to the endpoint
     * @return Application|ResponseFactory|Response Code 201 when a new student was created successfully<p>
     * Otherwise, returns a BadRequest
     *
     * @see Student
     */
    public function post(Request $request): Application|ResponseFactory|Response
    {
        $data = $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "dni" => "required|string",
            "curso" => "required|string"
        ]);

        $newStudent = Student::create([
            "nombre" => $data["nombre"],
            "apellidos" => $data["apellidos"],
            "dni" => $data["dni"],
            "curso" => $data["curso"]
        ]);

        // Student exists -> was created
        if ($newStudent) {
            // Created
            return response(content: "", status: 201);
        }

        // Bad Request
        return response(content: "", status: 400);
    }

    /**
     * Update an existing student
     *
     * @param Request $request The incoming request to the endpoint
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     * Code 200 when the student was updated correctly
     *
     * @see Student
     */
    public function put(Request $request): Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            "id" => "required|int",
            "nombre" => "nullable|string",
            "apellidos" => "nullable|string",
            "dni" => "nullable|string",
            "curso" => "nullable|string"
        ]);

        $student = Student::findOrFail($data["id"]);

        if (isset($data["nombre"])) {
            $student->nombre = $data["nombre"];
        }

        if (isset($data["apellidos"])) {
            $student->apellidos = $data["apellidos"];
        }

        if (isset($data["dni"])) {
            $student->dni = $data["dni"];
        }

        if (isset($data["curso"])) {
            $student->curso = $data["curso"];
        }

        $student->save();

        // Ok
        return response(content: "", status: 200);
    }

    /**
     * Delete a student
     *
     * @param Student $student
     * @return Response|Application|ResponseFactory Code 200 when a student was found and deleted successfully<p>
     * Otherwise, a 410 code gets returned
     *
     * @see Student
     */
    public function delete(Student $student): Application|Response|ResponseFactory
    {
        $deleted = $student->delete();

        if ($deleted) {
            // Ok
            return response(content: "", status: 200);
        }

        // Gone
        return response(status: 410);
    }
}
