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

            return response()->json($membership, 200);
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
            $membership->delete();

            return response()->json(['message' => 'Membresía eliminada con éxito'], 200);
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

}
