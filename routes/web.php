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
        //Rutas para las vistas principales del panel de administración
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('administration.dashboard');
        Route::get('/users', [App\Http\Controllers\AuthController::class, 'showUserList'])->name('administration.users');
        Route::get('/user-profiles', [App\Http\Controllers\ProfileController::class, 'showProfileList'])->name('administration.profile');
        Route::get('/roles', [App\Http\Controllers\RolController::class, 'showRoles'])->name('administration.roles');
        Route::get('/publication', [App\Http\Controllers\PublicationsController::class, 'showPublicationList'])->name('administration.publication');
        Route::get('/planes', [MembershipsController::class, 'showPlanesList'])->name('administration.planes');

        //======================= Rutas para ver las vistas de crear y editar ========================
        //Usuarios
        Route::get('/users/create', [AuthController::class, 'showCreateUserForm'])->name('Create.createUser');
        Route::get('/users/{id}/edit', [AuthController::class, 'showEditUserForm'])->name('Edit.editUser');
        //Roles
        Route::get('/roles/create', [RolController::class, 'showCreateRolForm'])->name('Create.createRol');
        Route::get('/roles/{id}/edit', [RolController::class, 'showEditRolForm'])->name('roles.edit');
        //Perfiles
        Route::get('/profiles/create', [ProfileController::class, 'showCreateProfileForm'])->name('Create.createProfile');
        Route::get('/profiles/{id}/edit', [ProfileController::class, 'showEditProfileForm'])->name('Edit.editProfile');
        //Publication
        Route::get('/publications/create', [PublicationsController::class, 'showCreatePublicationForm'])->name('Create.createPublication');
        Route::get('/publications/{id}/edit', [PublicationsController::class, 'showEditPublicationForm'])->name('Edit.editPublication');
        //Planes
        Route::get('/admin/planes/edit/{id}', [MembershipsController::class, 'showEditMembership'])->name('Edit.editPlanes');

        //======================== Rutas para crear ========================
        //Usarios
        Route::post('/users', [AuthController::class, 'createNewUser'])->name('admin.users.store');
        //Roles
        Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
        //Perfiles
        Route::post('/profiles', [ProfileController::class, 'createNewProfile'])->name('admin.profile.store');
        //publicación
        Route::post('/publications', [PublicationsController::class, 'createPublicationAdmin'])->name('admin.publication.store');

        //======================== Rutas para editar ========================
        //Usarios
        Route::put('/users/{id}', [AuthController::class, 'updateUser'])->name('admin.users.update');
        //Roles
        Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');
        //Perfiles
        Route::put('/profiles/{id}', [ProfileController::class, 'updateAdminProfile'])->name('admin.profile.update');
        //publicación
        Route::put('/publications/{id}', [PublicationsController::class, 'updatePublicationAdmin'])->name('admin.publication.update');
        //Planes
        Route::put('/admin/planes/update/{id}', [MembershipsController::class, 'updateMembership'])->name('admin.planes.update');

        //======================== Rutas para eliminar ========================
        //Usarios
        Route::delete('/users/{id}', [AuthController::class, 'deleteUser'])->name('admin.users.delete');
        //Roles
        Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
        //Perfiles
        Route::delete('/profiles/{id}', [ProfileController::class, 'deleteProfile'])->name('admin.profile.delete');
        //publicación
        Route::delete('/publications/{id}', [PublicationsController::class, 'deletePublicationAdmin'])->name('admin.publication.delete');
        //Planes
        Route::delete('/admin/planes/delete/{id}', [MembershipsController::class, 'deleteMembership'])->name('admin.planes.delete');
    });