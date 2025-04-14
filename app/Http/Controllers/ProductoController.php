<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //http://127.0.0.1:8000/api/producto?page=1&limit=5&q=mesa
        $limit = isset($request->limit) ? $request->limit : 10;
        //$q = isset($request->q) ? $request->q : "";

        if (isset($request->q)){

            $productos = Producto::orderBy('id','desc')
                                    ->where('nombre','LIKE','%'. $request->q .'%')
                                    ->orWhere('precio','LIKE','%'. $request->q .'%')
                                    ->with(['categoria'])
                                    ->paginate($limit);

            return response()->json($productos, 200);

        }else{
            $productos = Producto::orderBy('id','desc')
                                    ->with(['categoria'])
                                    ->paginate($limit);

            return response()->json($productos, 200);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             "nombre" => "required",
             "categoria_id" => "required"
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;

        $producto->save();

        return response()->json(["message" => "Producto resgistrado"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);
        if ($producto){
            return response()->json($producto, 200);
        }else{
            return response()->json(["message" => "Producto no encontrado"], 404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
       ]);

       $producto = Producto::find($id);
       $producto->nombre = $request->nombre;
       $producto->stock = $request->stock;
       $producto->precio = $request->precio;
       $producto->descripcion = $request->descripcion;
       $producto->categoria_id = $request->categoria_id;

       $producto->update();

       return response()->json(["message" => "Producto actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);
        $producto->estado = false;
        $producto->update();
        return response()->json(["message" => "Producto actualizado de estado"], 200);
    }

    public function actualizaImagen(Request $request, $id){
        if ($file = $request->file("imagen")){
            $direccion_url = time() . "-" . $file->getClientOriginalName();
            $file->move("imagenes",$direccion_url);

            $producto = Producto::find($id);
            $producto->imagen = "imagenes/" . $direccion_url;
            $producto->update();

            return response()->json(["message" => "Imagen actualizada"], 201);
        }else{
            return response()->json(["message" => "La imagen es obligatoria"], 422);
        }
    }
}
