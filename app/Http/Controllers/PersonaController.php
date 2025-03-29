<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$personas = DB::select("select * from personas");
        $personas = Persona::with(['user'])->orderBy('id','desc')->get();
        return response()->json($personas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "nombres" => "required|string|min:3|max:30",
            "apellidos" => "string|min:3|max:50"
        ]);

        $nombres = $request->nombres;
        $apellidos = $request->apellidos;

        //DB::insert("INSERT INTO personas (nombres, apellidos) values (?,?)", [$nombres, $apellidos]);

        //$persona = DB::table("personas")->insert(["nombres" => $nombres, "apellidos" => $apellidos]);

        $persona = new Persona();
        $persona->nombres = $nombres;
        $persona->apellidos = $apellidos;
        $persona->save();


        return response()->json(["mensaje" => "Persona Registrada"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function funGuardarPersonaUser(Request $request)
    {
        //validar datos personles y usuario
        $request->validate([
            "nombres" => "required|min:2|max:30",
            "apellidos" => "required|min:2|max:50",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|string"
        ]);

        DB::beginTransaction();

        try {

            //guadar user
            $user = new User();
            $user->name = $request->nombres;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            //guardar persona
            $persona = new Persona();
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->user_id = $user->id;
            $persona->save();

            DB::commit();

            return response()->json(["mensaje" => "Datos registrados correctmente"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["mensaje" => "Ocurrió error al registar los datos", "error" => $e->getMessage()], 400);
        }
    }

    public function funAddUserPersona(Request $request, $id)
    {
        $request->validate([
            "email" => "required|email|unique:users",
            "password" => "required|min:6|string"
        ]);
        
        DB::beginTransaction();

        try {
            $persona = Persona::find($id);

            //guadar user
            $user = new User();
            $user->name = $persona->nombres;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            // asignamos la cuenta de usuario
            $persona->user_id = $user->id;
            //$persona->save();
            $persona->update();

            DB::commit();

            return response()->json(["mensaje" => "Cuenta asignada a la persona"], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["mensaje" => "Ocurrió error al asignar cuenta de usuario ", "error" => $e->getMessage()], 400);
        }
    }
}
