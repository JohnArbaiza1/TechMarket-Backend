<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Estas rutas requieren autenticacion mediante un token
Route::middleware('auth:sanctum')->group(function () {
    //Ruta para obtener el usuario con el token
    Route::get('/me', [AuthController::class, 'getUser']);
    //Ruta de cerrar sesion
    Route::post('/logout', [AuthController::class, 'logout']);


    //Ruta para crear un perfil
    Route::post('/profile', [ProfileController::class, 'createProfile']);
    //Ruta para obtener un perfil
    Route::get('/profile/{id_user}', [ProfileController::class, 'getProfile']);
    //Ruta para actualizar un perfil
    Route::put('/profile/{id_user}', [ProfileController::class, 'updateProfile']);


});

