<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Auth; // Importa la clase Auth

class FollowController extends Controller
{
    // Método para seguir a un usuario
    public function follow($id)
    {
        // Encuentra al usuario que será seguido
        $userToFollow = User::findOrFail($id);

        // Obtiene el usuario actual
        $currentUser = Auth::user();

        // Verifica si el usuario intenta seguirse a sí mismo
        if ($userToFollow->id === $currentUser->id) {
            return response()->json(['message' => 'No puedes seguirte a ti mismo'], 400);
        }

        // Sincroniza la relación de seguimiento (sin eliminar los demás seguimientos)
        $currentUser->following()->syncWithoutDetaching([$userToFollow->id]);

        return response()->json(['message' => 'Usuario seguido correctamente', 'user' => $userToFollow]);
    }

    // Método para dejar de seguir a un usuario
    public function unfollow($id)
    {
        // Encuentra al usuario que será dejado de seguir
        $userToUnfollow = User::findOrFail($id);

        // Obtiene el usuario actual
        $currentUser = Auth::user();

        // Elimina la relación de seguimiento
        $currentUser->following()->detach($userToUnfollow->id);

        return response()->json(['message' => 'Usuario dejado de seguir correctamente', 'user' => $userToUnfollow]);
    }

    // Método para obtener los seguidores del usuario autenticado
    public function myFollowers(Request $request)
    {
        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Si hay búsqueda por nombre de usuario
        $search = $request->input('search');

        $followers = $user->followers()
            ->with('profile')
            ->when($search, function ($query, $search) {
                $query->where('user_name', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return response()->json($followers);
    }

    // Método para obtener a quiénes sigue el usuario autenticado
    public function myFollowing(Request $request)
    {
        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Si hay búsqueda por nombre de usuario
        $search = $request->input('search');

        $following = $user->following()
            ->with('profile')
            ->when($search, function ($query, $search) {
                $query->where('user_name', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return response()->json($following);
    }

}
