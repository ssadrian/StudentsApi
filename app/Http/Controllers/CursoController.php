<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Controller in charge with the C.R.U.D. of Courses
 *
 * @see Curso
 */
class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection
     */
    public function index(): Collection|array
    {
        return Curso::with(["profesor", "student"])->get();
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
            'nombre' => 'required|string'
        ]);

        DB::beginTransaction();
        $newCurso = Curso::create([
            'nombre' => $data['nombre']
        ]);

        // Student exists -> was created
        if ($newCurso) {
            DB::commit();
            // Created
            return response(content: '', status: 201);
        }

        DB::rollBack();
        // Bad Request
        return response(content: '', status: 400);
    }

    /**
     * Display the specified resource.
     *
     * @param Curso $curso
     * @return JsonResponse
     */
    public function show(Curso $curso): JsonResponse
    {
        $cursos = $this->index();

        if (isset($curso->id)) {
            $cursos = $cursos->where('id', $curso->id);
        }

        if (isset($curso->nombre)) {
            $cursos = $cursos->where('nombre', $curso->nombre);
        }

        return response()->json(
            $cursos
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Curso $curso
     * @return Response
     */
    public function update(Request $request, Curso $curso)
    {
        $data = $request->validate([
            'id' => 'required|int'
        ]);

        DB::beginTransaction();
        try {
            $cursos = Curso::find($data['id']);

            if (isset($curso->nombre)) {
                $cursos->nombre = $curso->nombre;
            }

            if (isset($curso->apellidos)) {
                $cursos->apellidos = $curso->apellidos;
            }

            if (isset($curso->dni)) {
                $cursos->dni = $curso->dni;
            }

            if (isset($curso->curso)) {
                $cursos->curso = $curso->curso;
            }

            $cursos->save();
        } catch (Exception $e) {
            DB::rollBack();
            return response(content: $e->getMessage(), status: 400);
        }

        // Ok
        DB::commit();
        return response(content: '', status: 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Curso $curso
     * @return Response
     */
    public function destroy(Curso $curso)
    {
        DB::beginTransaction();
        $deleted = $curso->delete();

        if ($deleted) {
            // Ok
            DB::commit();
            return response(content: '', status: 200);
        }

        // Gone
        DB::rollBack();
        return response(status: 410);
    }
}
