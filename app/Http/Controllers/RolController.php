<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;


class RolController extends Controller
{
    //Metodo para Listar todos los roles
    public function showRoles(Request $request)
    {
        try {
            $search = $request->input('search');
    
            $roles = Role::with('users') // 👈 Esto carga los usuarios relacionados
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%");
                })
                ->get();
    
            return view('administration.roles', compact('roles'));
    
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    // Metodo para Crear un nuevo rol
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'state' => 'required|boolean',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $role = Role::create($validated);

        return response()->json($role, 201);
    }

    //Metodo para Actualizar un rol existente
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
    
        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'state' => 'required|boolean',
        ]);
    
        $role->update($validated);
    
        return response()->json($role);
    }

    //Metodo para Eliminar un rol
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
    
}
