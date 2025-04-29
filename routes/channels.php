<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{id}', function ($user, $id) {

    // Verifica si el usuario esta en el chat
    $chat = \App\Models\Chats::find($id);
    if (!$chat) {
        return false;
    }

    return $user->id === $chat->user_one_id || $user->id === $chat->user_two_id;
});
Broadcast::channel('user.{id}', function ($user, $id) {

    // Permitir acceso solo si el usuario autenticado es el mismo que el ID del canal
    $isAuthorized = (int) $user->id === (int) $id;

    return $isAuthorized;
});