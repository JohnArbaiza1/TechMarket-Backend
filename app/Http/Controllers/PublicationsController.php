<?php

namespace App\Http\Controllers;
use App\Models\Publications;
use App\Models\User;
use App\Models\Memberships;

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
                'publication_status' => 'required|string',
                'publication_rating' => 'nullable|numeric|min:0|max:5',
                'tags' => 'nullable|string|max:255',
            ]);

        // Obtener el usuario para obtener su tipo de plan
        $user = User::find($request->id_user);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Obtener el id_membership (plan) del usuario
        $membershipId = $user->id_membership;

        // Obtenemos las publicaciones activas del usuario (no eliminadas)
        $currentPublications = Publications::where('id_user', $request->id_user)
            ->where('publication_status', '!=', 'deleted')
            ->count();

        //Obtenemos la membresia del usuario
        $membership = Memberships::find($membershipId);
        if (!$membership) {
            return response()->json(['error' => 'Membresía no encontrada'], 404);
        }


        // Verifica si el usuario ha alcanzado el límite de publicaciones
        if ($currentPublications >= 1 && !$membership->unlimited_publications) {
            return response()->json([
                'error' => 'Has alcanzado el límite de publicaciones de tu plan.',
                'current' => $currentPublications,
            ], 400);
        }


        // Crear la publicación si el usuario no ha alcanzado el límite
        $publication = Publications::create($request->all());
        return response()->json($publication, 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPublicationLimit($id_user)
    {
    try {
        // Obtener el usuario por su ID
        $user = User::find($id_user);
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        
        // Obtener el plan de membresía del usuario
        $membershipId = $user->id_membership;
        
        // Definir el límite de publicaciones basado en el tipo de plan
        switch ($membershipId) {
            case 1: // Plan Inicial
                $maxPublications = 1;
                break;
            case 2: // Plan Pro
                $maxPublications = 3;
                break;
            case 3: // Plan Enterprise Inicial
                $maxPublications = 1;
                break;
            case 4: // Plan Pro Enterprise
                $maxPublications = 5;
                break;
            case 5: // Plan Todo en Uno
                $maxPublications = -1; // Código para ilimitado
                break;
            default:
                $maxPublications = 0;
        }
        
        // Obtener el número actual de publicaciones (no eliminadas)
        $currentPublications = Publications::where('id_user', $id_user)
            ->where('publication_status', '!=', 'deleted')
            ->count();
        
        // Calcular publicaciones restantes
        $remainingPublications = $maxPublications == -1 ? 'Ilimitado' : ($maxPublications - $currentPublications);
        
        // Devolver información completa sobre límites
        return response()->json([
            'maxPublications' => $maxPublications == -1 ? 'Ilimitado' : $maxPublications,
            'currentPublications' => $currentPublications,
            'remainingPublications' => $remainingPublications
        ]);
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
            if ($publications->isEmpty()) {
                return response()->json(['error' => 'No se encontraron publicaciones'], 404);
            }

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

    /********************* Metodos para el Panel de Administración *********************/
    //Metodo para listar las publicaciones desde el backend
    public function showPublicationList(Request $request)
    {
        try {
            $search = $request->input('search');
    
            // Creamos una query base
            $query = Publications::query();
    
            // Si hay búsqueda, aplicamos el filtro
            if ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%");
            }
    
            // Ejecutamos la consulta
            $publications = $query->paginate(5)->withQueryString();
    
            // Pasamos la data a la vista
            return view('administration.publication', [
                'publication' => $publications,
                'search' => $search,
            ]);
            
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    //Metodo para ver la vista de crear publicacion
    public function showCreatePublicationForm()
    {
        $users = User::all();
        return view('Create.createPublication', compact('users'));
    }

    //Metodo para crear una publicacicón desde el panel
    public function createPublicationAdmin(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'publication_description' => 'nullable|string|max:1000',
                'publication_image' => 'nullable|string|max:2048',
                'id_user' => 'required|integer|exists:tbl_users,id',
                'quota' => 'required|integer|min:1',
                'publication_status' => 'required|string',
                'publication_rating' => 'nullable|numeric|min:0|max:5',
                'tags' => 'nullable|string|max:255',
            ]);

            Publications::create($request->all());

            return redirect()->route('administration.publication')->with('success', 'Publicación creada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la publicación: ' . $e->getMessage());
        }
    }

    //Metodo para ver la vista de editar publicacion
    public function showEditPublicationForm($id)
    {
        $publication = Publications::findOrFail($id);
        $users = User::all(); // por si necesitas editar el autor
        return view('Edit.editPublication', compact('publication', 'users'));
    }

    //Metodo para actualizar
    public function updatePublicationAdmin(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'publication_description' => 'nullable|string|max:1000',
                'publication_image' => 'nullable|string|max:2048',
                'id_user' => 'required|integer|exists:tbl_users,id',
                'quota' => 'required|integer|min:1',
                'publication_status' => 'required|string',
                'publication_rating' => 'nullable|numeric|min:0|max:5',
                'tags' => 'nullable|string|max:255',
            ]);

            $publication = Publications::findOrFail($id);
            $publication->update($request->all());

            return redirect()->route('administration.publication')->with('success', 'Publicación actualizada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la publicación: ' . $e->getMessage());
        }
    }

    //Metodo para eliminar
    public function deletePublicationAdmin($id)
    {
        try {
            $publication = Publications::findOrFail($id);
            $publication->delete();

            return redirect()->route('administration.publication')->with('success', 'Publicación eliminada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la publicación: ' . $e->getMessage());
        }
    }
}
