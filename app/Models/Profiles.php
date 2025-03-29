<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $table = 'tbl_profiles';

    protected $fillable = [
        'id_user',
        'profile_name',
        'profile_description',
        'profile_image',
        'profile_cover',
        'profile_location',
        'profile_website',
        'profile_phone',
        'profile_social_media',
        'created_at',
        'updated_at'
    ];

    public $timestamps = false;
}
