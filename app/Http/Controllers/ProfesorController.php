<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

/**
 * Controller in charge with the C.R.U.D. of Professors
 *
 * @see Profesor
 */
class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return Profesor::with(["user", "cursos"])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'dni' => 'required|string',
            'curso' => 'required|string'
        ]);

        $newProfesor = Profesor::create([
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'dni' => $data['dni'],
            'curso' => $data['curso']
        ]);

        // Profesor exists -> was created
        if ($newProfesor) {
            // Created
            return response(content: '', status: 201);
        }

        // Bad Request
        return response(content: '', status: 400);
    }

    /**
     * Display the specified resource.
     *
     * @param Profesor $profesor
     * @return JsonResponse
     */
    public function show(Profesor $profesor): JsonResponse
    {
        $profesores = $this->index();

        if (isset($profesor->id)) {
            $profesores = $profesores->where('id', $profesor->id);
        }

        if (isset($profesor->nombre)) {
            $profesores = $profesores->where('nombre', $profesor->nombre);
        }

        if (isset($profesor->apellidos)) {
            $profesores = $profesores->where('apellidos', $profesor->apellidos);
        }

        if (isset($profesor->dni)) {
            $profesores = $profesores->where('dni', $profesor->dni);
        }

        if (isset($profesor->curso)) {
            $profesores = $profesores->where('curso', $profesor->curso);
        }

        return response()->json(
            $profesores
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Profesor $profesor
     * @return Response
     */
    public function update(Request $request, Profesor $profesor): Response
    {
        $data = $request->validate([
            'id' => 'required|int',
            'nombre' => 'nullable|string',
            'apellidos' => 'nullable|string',
            'dni' => 'nullable|string',
            'curso' => 'nullable|string'
        ]);

        $oldProfesor = Profesor::findOrFail($profesor->id);

        if (isset($profesor->nombre)) {
            $oldProfesor->nombre = $profesor->nombre;
        }

        if (isset($profesor->apellidos)) {
            $oldProfesor->apellidos = $profesor->apellidos;
        }

        if (isset($profesor->dni)) {
            $oldProfesor->dni = $profesor->dni;
        }

        if (isset($profesor->curso)) {
            $oldProfesor->curso = $profesor->curso;
        }

        $oldProfesor->save();

        // Ok
        return response(content: '', status: 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Profesor $profesor
     * @return Response
     */
    public function destroy(Profesor $profesor): Response
    {
        $deleted = Profesor::destroy($profesor->id) !== 0;

        if ($deleted) {
            // Ok
            return response(content: '', status: 200);
        }

        // Gone
        return response(status: 410);
    }
}
