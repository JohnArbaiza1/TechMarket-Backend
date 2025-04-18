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
                'id_membership' => 'required|in:1,2,3,4,5',
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

    /********************* Metodos para el Panel de Administración *********************/

    // Mostrar el formulario de login
    public function showLoginForm()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('admin') || $user->hasRole('editor')) {
                return redirect()->route('administration.dashboard');
            }
        }

        return view('auth.login');
    }


    //Metodo para procesar el login de administración
    public function adminLogin(Request $request){

        try {
            $request->validate([
                'login' => 'required', // Email o username
                'user_pass' => 'required',
            ]);
    
            $user = User::where('email', $request->login)
                        ->orWhere('user_name', $request->login)
                        ->first();
    
            if (!$user || !Hash::check($request->user_pass, $user->user_pass)) {
                return back()->withErrors(['login' => 'Credenciales incorrectas']);
            }
    
            // Verificar si el usuario tiene los roles necesarios
            if (!$user->hasRole('admin') && !$user->hasRole('editor')) {
                return back()->withErrors(['login' => 'No tienes permisos para acceder al panel de administración']);
            }
    
            // Autenticación web (usando sesiones en lugar de tokens)
            auth()->login($user);

            \Log::info('Usuario autenticado: ' . $user->user_name . ', redirigiendo a dashboard');
    
            // Redirigir al dashboard admin
            return redirect()->route('administration.dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Error en login: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // Método para cerrar sesión en el panel
    public function adminLogout()
    {
        auth()->logout();
        return redirect()->route('home');
    }

    //Metodo de prueba para cargar los datos del usuario desde el backend
    public function showUserList(Request $request)
    {
        try {
            $search = $request->input('search');
    
            $users = User::when($search, function ($q) use ($search) {
                $q->where('user_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            })->paginate(10);
    
            return view('administration.users', compact('users', 'search'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showCreateUserForm() {
        return view('Create.createUser'); 
    }

    public function showEditUserForm($id) {
        $user = User::findOrFail($id);
        return view('Edit.editUser', compact('user'));
    }
    

    //Metodo para crear usuario desde el backend
    public function createNewUser(Request $request){
        try {
            $request->validate([
                'user_name' => 'required|max:255',
                'email' => 'required|email|unique:tbl_users,email',
                'user_pass' => 'required|min:8|regex:/[A-Za-z]/|regex:/[0-9]/|regex:/[$!%*?&-.]/',
                'id_membership' => 'required|in:1,2,3,4,5',
            ]);

            $user = User::create([
                'user_name' => $request->user_name,
                'email' => $request->email,
                'user_pass' => Hash::make($request->user_pass),
                'id_membership' => $request->id_membership,
                'published' => $request->published ?? false,
                'membership_status' => $request->membership_status ?? false,
                'user_rating' => 0,
                'remenber_token' => Str::random(60),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('administration.users')->with('success', 'Usuario creado correctamente');
    
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    //Metodo para Actualizar usuario
    public function updateUser(Request $request, $id)
    {
        try {
            $request->validate([
                'user_name' => 'required|max:255',
                'email' => 'required|email|unique:tbl_users,email,' . $id,
                'id_membership' => 'required|in:1,2,3,4,5',
            ]);

            $user = User::findOrFail($id);
            $user->user_name = $request->user_name;
            $user->email = $request->email;
            $user->id_membership = $request->id_membership;
            $user->published = $request->published ?? false;
            $user->membership_status = $request->membership_status ?? false;

            // Cambiar contraseña solo si se envía
            if ($request->filled('user_pass')) {
                $request->validate([
                    'user_pass' => 'min:8|regex:/[A-Za-z]/|regex:/[0-9]/|regex:/[$!%*?&-.]/',
                ]);
                $user->user_pass = Hash::make($request->user_pass);
            }

            $user->save();

            return redirect()->route('administration.users')->with('success', 'Usuario actualizado correctamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    //Metodo para Eliminar usuario
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.users')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    
}

