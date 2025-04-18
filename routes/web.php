<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\MembershipsController;

Route::get('/', function () {
    return view('welcome');
})->name('home'); 

// ***************************************Rutas para admin*********************************************

// Mostrar formulario de login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// Procesar login
Route::post('/login', [AuthController::class, 'adminLogin'])->name('admin.login');

// Logout
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

// Rutas protegidas del panel administrativo
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('administration')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('administration.dashboard');
        Route::get('/users', [App\Http\Controllers\AuthController::class, 'showUserList'])->name('administration.users');
        Route::get('/user-profiles', [App\Http\Controllers\ProfileController::class, 'showProfileList'])->name('administration.profile');
        Route::get('/roles', [App\Http\Controllers\RolController::class, 'showRoles'])->name('administration.roles');
        Route::get('/publication', [App\Http\Controllers\PublicationsController::class, 'showPublicationList'])->name('administration.publication');
        Route::get('/planes', [MembershipsController::class, 'showPlanesList'])->name('administration.planes');

        //Rutas para ver las vistas de crear y editar
        Route::get('/users/create', [AuthController::class, 'showCreateUserForm'])->name('Create.createUser');
        Route::get('/users/{id}/edit', [AuthController::class, 'showEditUserForm'])->name('Edit.editUser');
        Route::get('/roles/create', [RolController::class, 'showCreateRolForm'])->name('Create.createRol');
        Route::get('/roles/{id}/edit', [RolController::class, 'showEditRolForm'])->name('roles.edit');

        //Rutas para crear
        Route::post('/users', [AuthController::class, 'createNewUser'])->name('admin.users.store');
        Route::post('/roles', [RolController::class, 'store'])->name('roles.store');

        //Rutas para editar
        Route::put('/users/{id}', [AuthController::class, 'updateUser'])->name('admin.users.update');
        Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');
        
        //Rutas para eliminar
        Route::delete('/users/{id}', [AuthController::class, 'deleteUser'])->name('admin.users.delete');
        Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
    });