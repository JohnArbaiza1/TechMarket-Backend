<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'tbl_chat_messages';
    protected $fillable = [
        'id',
        'id_user',
        'message',
        'message_status',
        'id_chat',
    ];
}
