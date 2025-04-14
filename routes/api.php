<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembershipsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\ApplicantsControllerer;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Obtiene la lista de las membresias creadas
Route::get('/listMemberships', [MembershipsController::class, 'listMemberships']);

 //Ruta para obtener una publicacion
 Route::get('/publication/{id_publication}', [PublicationsController::class, 'getPublication']);
 //Ruta para listar todas las publicaciones
 Route::get('/publications', [PublicationsController::class, 'listPublications']);
 //Ruta para listar las publicaciones de un usuario
 Route::get('/publications/{id_user}', [PublicationsController::class, 'listPublicationsByUser']);
 // Ruta para obtener el límite de publicaciones de un usuario basado en su plan
Route::get('/user/{id_user}/publication-limit', [PublicationsController::class, 'getPublicationLimit']);



 //Estas rutas requieren autenticacion mediante un token
Route::middleware('auth:sanctum')->group(function () {
    //Ruta para obtener el usuario con el token
    Route::get('/me', [AuthController::class, 'getUser']);
    //Ruta para listar los usuarios registrados
    Route::get('/users', [AuthController::class, 'listUsers']);
    //Ruta de cerrar sesion
    Route::post('/logout', [AuthController::class, 'logout']);


    //Ruta para crear un perfil
    Route::post('/profile', [ProfileController::class, 'createProfile']);
    //Ruta para obtener un perfil
    Route::get('/profile/{id_user}', [ProfileController::class, 'getProfile']);
    //Ruta para actualizar un perfil
    Route::put('/profile/{id_user}', [ProfileController::class, 'updateProfile']);
    //Ruta para obtener el perfil de un usuario
    Route::get('/profile/user/{user_name}', [ProfileController::class, 'getProfileByUserName']);


    //Ruta para crear una membresia
    Route::post('/membership', [MembershipsController::class, 'createMembership']);
    //Ruta para obtener una membresia
    Route::get('/membership/{id_membership}', [MembershipsController::class, 'getMembership']);
    //Ruta para actualizar una membresia
    Route::put('/membership/{id_membership}', [MembershipsController::class, 'updateMembership']);
    //Ruta para eliminar una membresia
    Route::delete('/membership/{id_membership}', [MembershipsController::class, 'deleteMembership']);

    //Ruta para crear una publicacion
    Route::post('/publication', [PublicationsController::class, 'createPublication']);
    //Ruta para actualizar una publicacion
    Route::put('/publication/{id_publication}', [PublicationsController::class, 'updatePublication']);
    //Ruta para eliminar una publicacion
    Route::delete('/publication/{id_publication}', [PublicationsController::class, 'deletePublication']);

    //Ruta para crear un solicitante
    Route::post('/applicant', [ApplicantsControllerer::class, 'createApplicant']);
    //Ruta para obtener un solicitante
    Route::get('/applicant/{id_applicant}', [ApplicantsControllerer::class, 'getApplicant']);
    //Ruta para obtener los solicitantes de una publicacion
    Route::get('/applicants/publication/{id_publication}', [ApplicantsControllerer::class, 'getApplicantsByPublication']);
    //Ruta para obtener los solicitantes de un usuario
    Route::get('/applicants/user/{id_user}', [ApplicantsControllerer::class, 'getApplicantsByUser']);
    //Ruta para eliminar un solicitante
    Route::delete('/applicant/{id_applicant}', [ApplicantsControllerer::class, 'deleteApplicant']);
    //Ruta para eliminar al solicitante por id de usuario y publicacion
    Route::delete('/applicants/user/{id_user}/publication/{id_publication}', [ApplicantsControllerer::class, 'deleteApplicantByUserPublication']);


});

