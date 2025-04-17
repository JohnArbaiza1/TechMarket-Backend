<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.{id}', function ($user, $id) {
    Log::info('🔌 Intento de conexión al canal privado', [
        'usuario_autenticado_id' => $user->id,
        'canal_solicitado' => "chat.{$id}",
    ]);

    $userIds = explode('-', $id); // Divide la cadena del ID del canal en un array de IDs
    $userOneId = (int) $userIds[0];
    $userTwoId = (int) $userIds[1];

    return (int) $user->id === $userOneId || (int) $user->id === $userTwoId;
});