<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// ***************************************Rutas para admin*********************************************
Route::get('/dashboard', function () {
    return view('administration.dashboard');
})->name('dashboard');

Route::get('/dashboard/usuarios', [AuthController::class, 'showUserList'])->name('usuarios');
