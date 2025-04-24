<?php

namespace App\Http\Controllers;
use App\Models\Applicants;
use App\Models\Profiles;
use App\Models\Publications;
use App\Models\User;
use App\Models\Memberships;


use Illuminate\Http\Request;

class ApplicantsControllerer extends Controller
{
    public function createApplicant(Request $request)
    {
        try {
            $request->validate([
                'id_publication' => 'required|integer',
                'id_user' => 'required|integer',
            ]);


            $user = User::with('membership')->find($request->id_user);


            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Se verifica la membresía del usuario
            if (!$user->membership->unlimited_applications) {
                // Se cuenta cuántas veces el usuario ha aplicado
                $applicationsCount = Applicants::where('id_user', $user->id)->count();

                if ($applicationsCount >= 4) {
                    return response()->json(['error' => 'El usuario ha alcanzado el límite de aplicaciones permitidas para su membresía'], 203);
                }
            }

            // Verificar si la publicación existe
            $publication = Publications::find($request->id_publication);
            if (!$publication) {
                return response()->json(['error' => 'Publicación no encontrada'], 404);
            }

            // Verificar si el usuario ya está registrado con la publicación
            $applicant = Applicants::where('id_publication', $request->id_publication)
                ->where('id_user', $request->id_user)
                ->first();
            if ($applicant) {
                return response()->json(['error' => 'El usuario ya está registrado para esta publicación'], 400);
            }

            // Crear el registro de aplicación
            $applicant = Applicants::create($request->all());
            return response()->json($applicant, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getApplicant($id_applicant)
    {
        try {
            $applicant = Applicants::find($id_applicant);

            if (!$applicant) {
                return response()->json(['error' => 'Solicitante no encontrado'], 404);
            }

            return response()->json($applicant, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getApplicantsByPublication($id_publication)
    {
        try {
            $applicants = Applicants::where('id_publication', $id_publication)->get();

            if ($applicants->isEmpty()) {
                return response()->json([], 200);
            }
            // Obtener los detalles de los usuarios
            foreach ($applicants as $applicant) {
                $user = User::select('id', 'user_name', 'email')->find($applicant->id_user);
                if ($user) {
                    $applicant->users = $user;
                    //obtener informacion del perfil
                    $profile = Profiles::select('id','first_name', 'last_name', 'image_url')->where('id_user', $applicant->id_user)->first();
                    if ($profile) {
                        $applicant->users->profile = $profile;
                    } else {
                        return response()->json(['error' => 'Perfil del usuario no encontrado'], 200);
                    }
                } else {
                    return response()->json(['error' => 'Usuario no encontrado'], 200);
                }
            }
            // Devolver la lista de solicitantes con detalles de usuario
            return response()->json($applicants, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getApplicantsByUser($id_user)
    {
        try {
            $applicants = Applicants::where('id_user', $id_user)->get();

            if ($applicants->isEmpty()) {
                return response()->json($applicants, 200);
            }

            return response()->json($applicants, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteApplicant($id_applicant)
    {
        try {
            $applicant = Applicants::find($id_applicant);

            if (!$applicant) {
                return response()->json(['error' => 'Solicitante no encontrado'], 404);
            }

            $applicant->delete();

            return response()->json(['message' => 'Solicitante eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteApplicantByUserPublication($user_id, $publication_id)
    {
        try {
            $applicant = Applicants::where('id_publication', $publication_id)
                ->where('id_user', $user_id)
                ->first();

            if (!$applicant) {
                return response()->json(['error' => 'Solicitante no encontrado'], 203);
            }

            $applicant->delete();

            return response()->json(['message' => 'Solicitante eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
