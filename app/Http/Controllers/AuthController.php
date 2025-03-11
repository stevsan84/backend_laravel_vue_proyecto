<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function funLogin(Request $request){
        // validar datos
       $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        //verificar credenciales
        if(!Auth::attempt($credenciales)){
            return response()->json(["mensaje" => "Credenciales Incorrectas"],401);
        }
        //generar un token
        $token = $request->user()->createToken("Token Auth")->plainTextToken;

        //responder
        return response()->json(["access_token" => $token, "user" => $request->user()],201);
    }

    public function funRegister(Request $request){
        
    }

    public function funProfile(Request $request){
        $user = $request->user();
        return response()->json($user, 200);
    }

    public function funLogout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(["mensaje" => "Salió"], 200);
    }
}
