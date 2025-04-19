<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'tbl_profiles';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'description',
        'education',
        'social_media_links',
        'work_experience',
        'skills',
        'image_url', 
        'id_user',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
