<?php

namespace App\Http\Controllers;
use App\Models\Profiles;
use App\Models\User;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function createProfile(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:9',
                'address' => 'nullable|string|max:255',
                'image_url' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'social_media_links' => 'nullable|string|max:1000',
                'education' => 'nullable|string|max:1000',
                'work_experience' => 'nullable|string|max:1000',
                'skills' => 'nullable|string|max:1000',
                'id_user' => 'required|integer'
            ]);
            // Verificar si el usuario existe
            $user = User::find($request->id_user);
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontradp'], 404);
            }
            // Verificar si el perfil ya existe
            $existingProfile = Profiles::where('id_user', $request->id_user)->first();
            if ($existingProfile) {
                return response()->json(['error' => 'El perfil ya existe'], 409);
            }
            //formatear telefono
            $request->phone_number = preg_replace('/[^0-9]/', '', $request->phone_number);
            // Verificar si el teléfono tiene 8 dígitos
            if (strlen($request->phone_number) != 8) {
                return response()->json(['error' => 'El numero de telefono no debe de superar 8 digitos'], 422);
            }
            // Verificar si el nombre y apellido tienen un máximo de 255 caracteres
            if (strlen($request->first_name) > 255 || strlen($request->last_name) > 255) {
                return response()->json(['error' => 'El nombre o el apellido supera el maximo de 255 caracteres'], 422);
            }
            // Verificar si la dirección tiene un máximo de 255 caracteres
            if (strlen($request->address) > 255) {
                return response()->json(['error' => 'La direccion supera los 255 caracteres'], 422);
            }
            // Verificar si la descripción tiene un máximo de 1000 caracteres
            if (strlen($request->description) > 1000) {
                return response()->json(['error' => 'La descripcion supera los 1000 caracteres'], 422);
            }
            //Formatear telefono
            $request->phone_number = substr($request->phone_number, 0, 4) . '-' . substr($request->phone_number, 4);


            // Crear el perfil
            $profile = Profiles::create($request->all());

            return response()->json($profile, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getProfile($id_user)
    {
        try {
            $profile = Profiles::where('id_user', $id_user)->first();
            if (!$profile) {
                return response()->json([], 200);
            }
            return response()->json($profile, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function updateProfile(Request $request, $id_user)
    {
        try {
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:9',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image_url' => 'nullable|string|max:255',
                'social_media_links' => 'nullable|string|max:1000',
                'education' => 'nullable|string|max:1000',
                'work_experience' => 'nullable|string|max:1000',
                'skills' => 'nullable|string|max:1000',
            ]);

            // Verificar si el perfil existe
            $profile = Profiles::where('id_user', $id_user)->first();
            if (!$profile) {
                return response()->json(['error' => 'Perfil no encontrado'], 404);
            }

            // Limpiar y validar teléfono
            if (!empty($validatedData['phone_number'])) {
                $phone = preg_replace('/[^0-9]/', '', $validatedData['phone_number']);

                if (strlen($phone) != 8) {
                    return response()->json(['error' => 'El número de teléfono debe tener exactamente 8 dígitos.'], 422);
                }

                // Formatear el teléfono con guion
                $request->phone_number = substr($request->phone_number, 0, 4) . '-' . substr($request->phone_number, 4);
            }

            // Verificar si el nombre y apellido tienen un máximo de 255 caracteres
            if (strlen($request->first_name) > 255 || strlen($request->last_name) > 255) {
                return response()->json(['error' => 'El nombre o el apellido supera el maximo de 255 caracteres'], 422);
            }
            // Verificar si la dirección tiene un máximo de 255 caracteres
            if (strlen($request->address) > 255) {
                return response()->json(['error' => 'La direccion supera los 255 caracteres'], 422);
            }
            // Verificar si la descripción tiene un máximo de 1000 caracteres
            if (strlen($request->description) > 1000) {
                return response()->json(['error' => 'La descripcion supera los 1000 caracteres'], 422);
            }

            // Actualizar el perfil
            $profile->update($validatedData);

            return response()->json($profile, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //obtener perfil por user_name
    public function getProfileByUserName($user_name)
    {
        try {
    
            if (empty($user_name) || !is_string($user_name)) {
                return response()->json(['error' => 'Nombre de usuario inválido'], 400);
            }
            $user = User::where('user_name', $user_name)->first();
    
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 200);
            }

            $user->profile = Profiles::where('id_user', $user->id)->first();
    
            if (!$user->profile) {
                return response()->json([], 200);
            }
    
            return response()->json($user, 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /********************* Metodos para el Panel de Administración *********************/
    //Metodo  para cargar los datos del perfil desde el backend
    public function showProfileList(Request $request)
    {
        try {
            $query = Profiles::query();
    
            // Se envía un término de búsqueda
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'ILIKE', "%$search%")
                    ->orWhere('last_name', 'ILIKE', "%$search%")
                    ->orWhere('skills', 'ILIKE', "%$search%")
                    ->orWhere('work_experience', 'ILIKE', "%$search%");
                });
            }
    
            // Paginamos
            $profile = $query->paginate(5)->withQueryString();
    
            return view('administration.profile', compact('profile'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Metodo para ver la vista de crear profile
    public function showCreateProfileForm() {
        $users = User::all();
        return view('Create.createProfile', compact('users')); 
    }

    //Metodo para crear un perfil desde el panel
    public function createNewProfile(Request $request){
        try {
            $validated = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:9',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image_url' => 'nullable|string|max:255',
                'social_media_links' => 'nullable|string|max:1000',
                'education' => 'nullable|string|max:1000',
                'work_experience' => 'nullable|string|max:1000',
                'skills' => 'nullable|string|max:1000',
                'id_user' => 'required|exists:tbl_users,id',
            ]);
    
            // Validación del teléfono
            if (!empty($validated['phone_number'])) {
                $phone = preg_replace('/[^0-9]/', '', $validated['phone_number']);
                if (strlen($phone) != 8) {
                    return back()->with('error', 'El número de teléfono debe tener 8 dígitos.');
                }
                $validated['phone_number'] = substr($phone, 0, 4) . '-' . substr($phone, 4);
            }
    
            // Verificamos si ya tiene un perfil ese usuario
            if (Profiles::where('id_user', $validated['id_user'])->exists()) {
                return back()->with('error', 'Este usuario ya tiene un perfil.');
            }
    
            Profiles::create($validated);
    
            return redirect()->route('administration.profile')->with('success', 'Perfil creado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el perfil: ' . $e->getMessage());
        }
    }

    //Metodo para mostrar formulario de edición del perfil
    public function showEditProfileForm($id)
    {
        try {
            $profile = Profiles::findOrFail($id);
            $users = User::all();
            return view('Edit.editProfile', compact('profile', 'users'));
        } catch (\Exception $e) {
            return back()->with('error', 'Perfil no encontrado: ' . $e->getMessage());
        }
    }

    // Método para actualizar un perfil existente
    public function updateAdminProfile(Request $request, $id){

        try {
            $validated = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:9',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image_url' => 'nullable|string|max:255',
                'social_media_links' => 'nullable|string|max:1000',
                'education' => 'nullable|string|max:1000',
                'work_experience' => 'nullable|string|max:1000',
                'skills' => 'nullable|string|max:1000',
                'id_user' => 'required|exists:tbl_users,id',
            ]);
    
            if (!empty($validated['phone_number'])) {
                $phone = preg_replace('/[^0-9]/', '', $validated['phone_number']);
                if (strlen($phone) != 8) {
                    return back()->with('error', 'El número de teléfono debe tener 8 dígitos.');
                }
                $validated['phone_number'] = substr($phone, 0, 4) . '-' . substr($phone, 4);
            }
    
            $profile = Profiles::findOrFail($id);
            $profile->update($validated);
    
            return redirect()->route('administration.profile')->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }
    }

    // Método para eliminar un perfil
    public function deleteProfile($id)
    {
        try {
            $profile = Profiles::findOrFail($id);
            $profile->delete();

            return redirect()->route('administration.profile')->with('success', 'Perfil eliminado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el perfil: ' . $e->getMessage());
        }
    }
}
