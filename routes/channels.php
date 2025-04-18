<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{id}', function ($user, $id) {
    Log::info('🔌 Intento de conexión al canal privado', [
        'usuario_autenticado_id' => $user->id,
        'canal_solicitado' => "chat.{$id}",
    ]);

    // Verifica si el usuario esta en el chat
    $chat = \App\Models\Chats::find($id);
    if (!$chat) {
        Log::warning('🚫 Canal no encontrado', [
            'canal_solicitado' => "chat.{$id}",
        ]);
        return false;
    }

    return $user->id === $chat->user_one_id || $user->id === $chat->user_two_id;
});