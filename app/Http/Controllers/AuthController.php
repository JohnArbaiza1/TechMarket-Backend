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
                'id_membership' => 'required|in:1,3',
            ]);

            //crea el nuevo usuario para almacenarlo en la DB
            $user = User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'user_pass' => Hash::make($request->user_pass), //Password cifrado
                'published' => false,
                'id_membership'=> $request->id_membership,
                'membership_status' => false,
                'user_rating' => 0,
                'remenber_token' => Str::random(60), // Token aleatorio
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $token = $user->createToken($user->email)->plainTextToken;
            //Retornamos una respuesta indicando que el usuario fue creado correctamente
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            // En caso de error, retornar un mensaje de error con el detalle de la excepción
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    //metodo para el login
    public function login(Request $request) {
        try {
            
            $request->validate([
                'login' => 'required', // Puede ser email o username
                'user_pass' => 'required',
            ]);

            
            $user = User::where('email', $request->login)->orWhere('user_name', $request->login)->first();
    
            if (!$user || !Hash::check($request->user_pass, $user->user_pass)) {
                return response()->json([
                    'message' => 'Credenciales incorrectas',
                ], 401);
            }

            $token = $user->createToken($user->email)->plainTextToken;

            //Retornamos el token
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    //metodo para el cierre de sesión 
    public function logout(Request $request) {
        try {
            // Se obtiene el token de la solicitud
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json([
                    'message' => 'Token no proporcionado',
                ], 400);
            }

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Sesión cerrada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    //obtener informacion del usuario mediante token
    public function getUser(Request $request) {
        try {
            $user = $request->user();
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Metodo para mostrar todos los usuarios registrados
    public function listUsers()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Metodo para mostrar un usuario por su id
    public function getUserById($id)
    {
        try {
            $user = User::findOrFail($id)->only(['id', 'user_name']);
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}

