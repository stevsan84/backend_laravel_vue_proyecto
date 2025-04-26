<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $categorias = Categoria::orderBy('id', 'desc')->get();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al obtener los datos", "erros" => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required"
        ]);

        try {
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            //$categoria->estado = $request->estado;

            $categoria->save();

            return response()->json(["message" => "Categoría resgistrada"], 201);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al registrar los datos", "erros" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            return response()->json($categoria, 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al obtener los datos", "erros" => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required"
        ]);

        try {
            $categoria = Categoria::findOrFail($id);

            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->estado = $request->estado;

            $categoria->update();

            return response()->json(["message" => "Categoría actualizada"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al registar los datos", "erros" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->estado = !$categoria->estado;
            $categoria->update();

            return response()->json(["message" => "Categoría eliminada"], 200);
        } catch (\Exception $e) {
            return response()->json(["message" => "Error al eliminar los datos", "erros" => $e->getMessage()], 500);
        }
    }
}
