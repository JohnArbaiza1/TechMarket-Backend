<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chats;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {
        try {
            $request->validate([
                'user_one_id' => 'required',
                'user_two_id' => 'required',
                'id_publication' => 'nullable',
            ]);

            // Crear el chat
            $chat = Chats::create([
                'user_one_id' => $request->user_one_id,
                'user_two_id' => $request->user_two_id,
                'id_publication' => $request->id_publication,
            ]);

            return response()->json($chat, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el chat: ' . $e->getMessage()], 500);
        }
    }
    //Obtener todos los chats del usuario logueado
    public function getChats(Request $request)
    {
        try {
            $chats = Chats::where('user_one_id', $request->user()->id)
                ->orWhere('user_two_id', $request->user()->id)
                ->pluck('id');
                

            return response()->json($chats, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los chats: ' . $e->getMessage()], 500);
        }
    }
}
