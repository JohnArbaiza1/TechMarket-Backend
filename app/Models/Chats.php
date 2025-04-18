<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table = 'tbl_chats';
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'id_publication',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'id_chat');
    }

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id', 'id');
    }
    
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id', 'id');
    }
}
