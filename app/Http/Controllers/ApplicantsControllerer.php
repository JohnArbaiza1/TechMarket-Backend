<?php

namespace App\Http\Controllers;
use App\Models\Applicants;
use App\Models\Publications;
use App\Models\User;

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

            // Verificar si la publicación existe
            $publication = Publications::find($request->id_publication);
            if (!$publication) {
                return response()->json(['error' => 'Publicación no encontrada'], 404);
            }
            // Verifica si el usuario ya esta registrado con la publicacion
            $applicant = Applicants::where('id_publication', $request->id_publication)
                ->where('id_user', $request->id_user)
                ->first();
            if ($applicant) {
                return response()->json(['error' => 'El usuario ya está registrado para esta publicación'], 400);
            }
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
                return response()->json(['error' => 'No hay solicitantes para esta publicación'], 404);
            }

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
                return response()->json(['error' => 'No hay solicitantes para este usuario'], 404);
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

}
