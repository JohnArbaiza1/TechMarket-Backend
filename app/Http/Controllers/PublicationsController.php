<?php

namespace App\Http\Controllers;
use App\Models\Publications;
use App\Models\User;

use Illuminate\Http\Request;

class PublicationsController extends Controller
{
    public function createPublication(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'publication_description' => 'nullable|string|max:1000',
                'publication_image' => 'nullable|string|max:2048',
                'id_user' => 'required|integer',
                'quota' => 'required|integer|min:1',
                'publication_status' => 'required|boolean',
                'publication_rating' => 'nullable|numeric|min:0|max:5',
                'tags' => 'nullable|string|max:255',
            ]);

            $publication = Publications::create($request->all());

            return response()->json($publication, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPublication($id_publication)
    {
        try {
            $publication = Publications::find($id_publication);

            if (!$publication) {
                return response()->json(['error' => 'Publicación no encontrada'], 404);
            }

            return response()->json($publication, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePublication(Request $request, $id_publication)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'publication_description' => 'nullable|string|max:1000',
                'publication_image' => 'nullable|string|max:2048',
                'quota' => 'required|integer|min:1',
                'publication_status' => 'required|boolean',
                'publication_rating' => 'nullable|numeric|min:0|max:5',
                'tags' => 'nullable|string|max:255',
            ]);

            $publication = Publications::find($id_publication);

            if (!$publication) {
                return response()->json(['error' => 'Publicación no encontrada'], 404);
            }

            $publication->update($request->all());

            return response()->json($publication, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deletePublication($id_publication)
    {
        try {
            $publication = Publications::find($id_publication);

            if (!$publication) {
                return response()->json(['error' => 'Publicación no encontrada'], 404);
            }

            $publication->delete();

            return response()->json(['message' => 'Publicación eliminada con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function listPublications()
    {
        try {
            $publications = Publications::all();

            return response()->json($publications, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function listPublicationsByUser($id_user)
    {
        try {
            $publications = Publications::where('id_user', $id_user)->get();

            if ($publications->isEmpty()) {
                return response()->json(['error' => 'No se encontraron publicaciones para este usuario'], 404);
            }

            return response()->json($publications, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
