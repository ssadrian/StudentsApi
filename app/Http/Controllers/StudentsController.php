<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Console\Application;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;

class StudentsController extends Controller
{
    public function getAll(): Collection
    {
        return Student::all();
    }

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

    public function post(Request $request): Application|ResponseFactory|Response
    {
        $data = $request->validate([
            "nombre" => "required|string",
            "apellidos" => "required|int",
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
            return response(status: 201);
        }

        // Bad Request
        return response(status: 400);
    }

    public function put(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "id" => "required|int",
            "nombre" => "nullable|string",
            "apellidos" => "nullable|string",
            "dni" => "nullable|string",
            "curso" => "nullable|string"
        ]);

        $product = Student::findOrFail($data["id"]);

        if (isset($data["nombre"])) {
            $product->nombre = $data["nombre"];
        }

        if (isset($data["apellidos"])) {
            $product->nombre = $data["apellidos"];
        }

        if (isset($data["dni"])) {
            $product->dni = $data["dni"];
        }

        if (isset($data["curso"])) {
            $product->curso = $data["curso"];
        }

        $product->save();

        // Ok
        return response(status: 200);
    }

    public function delete(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            "id" => "required|int"
        ]);

        $deleted = Student::destroy($data["id"]) !== 0;

        if ($deleted) {
            // Ok
            return response(status: 200);
        }

        // Gone
        return response(status: 410);
    }
}
