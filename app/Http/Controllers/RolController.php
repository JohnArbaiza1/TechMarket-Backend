<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;


class RolController extends Controller
{
    //Metodo para Listar todos los roles
    public function showRoles(Request $request)
    {
        try {
            $search = $request->input('search');
            
            $roles = Role::with('users') // Carga los usuarios relacionados con los roles
                ->when($search, function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%");
                })
                ->get();
    
            return view('administration.roles', compact('roles'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function showCreateRolForm() {
        $allUsers = User::all();
        return view('Create.createRol', compact('allUsers'));
    }

    public function showEditRolForm($id) {
        // Buscar el rol por ID
        $roles = Role::findOrFail($id);
        
        // Obtener todos los usuarios y los asignados al rol
        $allUsers = User::all(); // Obtener todos los usuarios
        $assignedUsers = $roles->users()->pluck('id')->toArray(); // Obtener los usuarios asignados al rol
    
        // Retornar la vista de editar rol con los datos necesarios
        return view('Edit.editRol', compact('roles', 'allUsers', 'assignedUsers'));
    }
    

    // Metodo para Crear un nuevo rol
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'state' => 'required|boolean',
        ]);
    
        // Crear el rol
        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'state' => $validated['state'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Asignar los usuarios seleccionados
        if ($request->has('users')) {
            $role->users()->attach($request->users); // Asigna los usuarios al rol
        }
    
        // Redirigir al listado de roles con un mensaje de éxito
        return redirect()->route('administration.roles')->with('success', 'Rol creado y usuarios asignados correctamente');
    }
    

    //Metodo para Actualizar un rol existente
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        
        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }
        
        // Validación de la entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'state' => 'required|boolean',
        ]);
    
        // Actualizar el rol
        $role->update($validated);
    
        // Asignar los usuarios seleccionados (si los hay)
        if ($request->has('users')) {
            $role->users()->sync($request->input('users'));
        }
    
        return redirect()->route('administration.roles')->with('success', 'Rol actualizado correctamente');
    }
    

    //Metodo para Eliminar un rol
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }

        $role->delete();

        return redirect()->route('administration.roles')->with('success', 'Rol eliminado correctamente');
    }
    
}
