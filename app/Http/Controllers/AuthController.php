<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //Metodo para el registro
    public function register(Request $request)
    {
        try {
            // //validando para los datos que viene del frotend
            $request->validate([
                'user_name' => 'required|max:255',
                'email' => 'required|email|unique:tbl_users,email',
                'user_pass' => 'required|min:8|regex:/[A-Za-z]/|regex:/[0-9]/|regex:/[$!%*?&-.]/',
            ]);

            //crea el nuevo usuario para almacenarlo en la DB
            $user = User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'user_pass' => Hash::make($request->user_pass), //Password cifrado
                'published' => false,
                'id_membership' => 1,
                'membership_status' => false,
                'user_rating' => 0,
                'remenber_token' => Str::random(60), // Token aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            //Retornamos una respuesta indicando que el usuario fue creado correctamente
            return response($user, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En caso de error, retornar un mensaje de error con el detalle de la excepción
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    //metodo para el login
    public function login(Request $request) {}

    //metodo para el cierre de sesión 
    public function logout(Request $request) {}
}
