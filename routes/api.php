<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    // registrar persona con cuenta de usuario
    Route::post("/persona/guardar-persona-user", [PersonaController::class,"funGuardarPersonaUser"]);

    //asignara cuenta user a persona
    Route::post("/persona/{id}/adduser", [PersonaController::class,"funAddUserPersona"]);

    //subida de imagen producto
    Route::post("/producto/{id}/subir-imagen",[ProductoController::class,"actualizaImagen"]);

    //CRUS API REST USER
    Route::get("/user", [UserController::class, "funListar"]);
    Route::post("/user", [UserController::class, "funGuardar"]);
    Route::get("/user/{id}", [UserController::class, "funMostrar"]);
    Route::put("/user/{id}", [UserController::class, "funModificar"]);
    Route::delete("/user/{id}", [UserController::class, "funEliminar"]);

    //CRUD Roles
    Route::apiResource("role", RoleController::class);
    Route::apiResource("persona", PersonaController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("documento", DocumentoController::class);

    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("pedido", PedidoController::class);
    Route::apiResource("producto", ProductoController::class);

});

//Auth
Route::prefix('/v1/auth')->group(function () {
    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get("/profile", [AuthController::class, "funProfile"]);
        Route::post("/logout", [AuthController::class, "funLogout"]);
    });
});


//redireccion (NO AUTENTICADO)
Route::get("/no-autentiacado", function(){
    return["mensaje" => "SIN PERMISO"];
})->name("login");