<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicants extends Model
{
    protected $table = 'tbl_applicants';
    protected $fillable = [
        'id',
        'id_publication',
        'id_user',
        'id_selected',
        'created_at',
        'updated_at',
    ];
}
