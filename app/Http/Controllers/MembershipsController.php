<?php

namespace App\Http\Controllers;
use App\Models\Memberships;

use Illuminate\Http\Request;

class MembershipsController extends Controller
{
    public function createMembership(Request $request)
    {
        try {
            
            $request->validate([
                'membership_name' => 'required|string|max:255',
                'membership_description' => 'nullable|string|max:1000',
                'price' => 'required|numeric|min:0',
                'unlimited_applications' => 'required|boolean',
                'unlimited_publications' => 'required|boolean',
            ]);
            
            $membership = Memberships::create($request->all());

            return response()->json($membership, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getMembership($id_membership)
    {
        try {
            $membership = Memberships::find($id_membership);

            if (!$membership) {
                return response()->json(['error' => 'Membresía no encontrada'], 404);
            }

            return response()->json($membership, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function updateMembership(Request $request, $id_membership)
    {
        try {
            $request->validate([
                'membership_name' => 'required|string|max:255',
                'membership_description' => 'nullable|string|max:1000',
                'price' => 'required|numeric|min:0',
                'unlimited_applications' => 'required|boolean',
                'unlimited_publications' => 'required|boolean',
            ]);

            $membership = Memberships::find($id_membership);

            if (!$membership) {
                return response()->json(['error' => 'Membresía no encontrada'], 404);
            }

            $membership->update($request->all());

            return redirect()->route('administration.planes')->with('success', 'Plan editado correctamente');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteMembership($id_membership)
    {
        try {
            $membership = Memberships::find($id_membership);

            if (!$membership) {
                return response()->json(['error' => 'Membresía no encontrada'], 404);
            }
            
            // Verificar si hay usuarios asociados a esta membresía
            $usersWithMembership = \App\Models\User::where('id_membership', $id_membership)->exists();

            if ($usersWithMembership) {
                return back()->with('error', 'No puedes eliminar esta membresía porque hay usuarios asociados a ella.');
            }

            // Eliminar la membresía si no está siendo utilizada
            $membership->delete();

            return redirect()->route('administration.planes')->with('success', 'Plan eliminado correctamente');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function listMemberships()
    {
        try {
            // Obtiene todas las membresías
            $memberships = Memberships::all();

            return response()->json($memberships, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /********************* Metodos para el Panel de Administración *********************/
    //Metodo para listar los planes desde el backend
    public function showPlanesList(Request $request)
    {
        try {
            $membership = Memberships::all();
            return view('administration.planes', [
                'planes' => $membership
            ]);
        } catch (\Exception $e) {
            // Capturamos cualquier excepción y la mostramos
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //Método para ver la vista de edición
    public function showEditMembership($id)
    {
        try {
            $membership = Memberships::findOrFail($id);
            return view('Edit.editPlanes', compact('membership'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Membresía no encontrada.');
        }
    }
}
