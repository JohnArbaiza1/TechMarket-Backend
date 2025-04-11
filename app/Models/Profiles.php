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
        'image_url', 
        'id_user',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
