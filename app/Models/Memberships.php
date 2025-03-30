<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memberships extends Model
{
    protected $table = 'tbl_memberships';

    protected $fillable = [
        'id',
        'membership_name',
        'membership_description',
        'price',
        'unlimited_applications',
        'unlimited_publications',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;
}
