<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function funListar(){
        //$users = DB::select("select * from users"); //hacer consultas sql
        
        //Query Builder
        //$users = DB::table("users")->get();
        //$users = DB::table("users")->select("name")->get();

        //Eloquente ORM
        $users = User::get();

        return $users;
    }

    public function funGuardar(Request $request){

        //validar datos personles y usuario
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|string"
        ]);

        try{

            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
    
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = $password;
    
            $user->save();
    
            return response()->json(["mensaje" => "Usuario registrado en la BD"], 200);

        }catch(\Exception $e) {
            DB::rollBack();
            return response()->json(["mensaje" => "Error del Servidor", "error" => $e->getMessage()],500);
        }

       
        
    }

    public function funMostrar($id){
        //$user = User::find($id);
        $user = User::findOrFail($id);
        return response()->json($user,200);
    }

    public function funModificar(Request $request, $id){
        $user = User::findOrFail($id);
        
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user->name = $name;
        $user->email = $email;
        $user->password = $password;

        $user->update();

        return response()->json(["mensaje" => "Usuario Actualizado"],201);
    }

    public function funEliminar($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(["mensaje" => "Usuario Eliminado"],200);
    }
}

