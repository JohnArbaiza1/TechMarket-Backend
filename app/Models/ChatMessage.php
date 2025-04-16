<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'tbl_chat_messages';
    protected $fillable = [
        'id',
        'id_user_one',
        'id_user_two',
        'message',
        'message_status'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'id_user_one');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'id_user_two');
    }
}
