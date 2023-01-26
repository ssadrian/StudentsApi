<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Console\Application;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
     * @return JsonResponse|Response|ResponseFactory Code 201 when a new student was created successfully<p>
     * Otherwise, returns a BadRequest
     *
     * @see Student
     */
    public function post(Request $request)
    {
        $data = $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|string",
            "dni" => "required|string",
            "curso" => "required|string"
        ]);

        DB::beginTransaction();
        try {
            Student::create([
                'nombre' => $data['nombre'],
                'apellidos' => $data['apellidos'],
                'dni' => $data['dni'],
                'curso' => $data['curso']
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        // Ok
        DB::commit();
        return response(status: 200);
    }

    /**
     * Update an existing student
     *
     * @param Request $request The incoming request to the endpoint
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|Response
     * Code 200 when the student was updated correctly
     *
     * @see Student
     */
    public function put(Request $request)
    {
        $data = $request->validate([
            "id" => "required|int",
            "nombre" => "nullable|string",
            "apellidos" => "nullable|string",
            "dni" => "nullable|string",
            "curso" => "nullable|string"
        ]);

        DB::beginTransaction();
        try {
            $student = Student::find($data['id']);

            if (isset($data['nombre'])) {
                $student->nombre = $data['nombre'];
            }

            if (isset($data['apellidos'])) {
                $student->apellidos = $data['apellidos'];
            }

            if (isset($data['dni'])) {
                $student->dni = $data['dni'];
            }

            if (isset($data['curso'])) {
                $student->curso = $data['curso'];
            }

            $student->save();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        // Ok
        DB::commit();
        return response(content: "", status: 200);
    }

    /**
     * Delete a student
     *
     * @param Student $student
     * @return JsonResponse|Response|ResponseFactory Code 200 when a student was found and deleted successfully<p>
     * Otherwise, a 410 code gets returned
     *
     * @see Student
     */
    public function delete(Student $student)
    {
        DB::beginTransaction();
        try {
            $student->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 410);
        }

        // Ok
        return response(status: 200);
    }
}
