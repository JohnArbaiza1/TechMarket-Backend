<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publications extends Model
{
    protected $table = 'tbl_publications';

    protected $fillable = [
        'id',
        'title',
        'publication_description',
        'publication_image',
        'id_user',
        'quota',
        'publication_status',
        'publication_rating',
        'tags',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;
}
