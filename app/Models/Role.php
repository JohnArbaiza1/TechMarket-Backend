<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'tbl_roles';

    protected $fillable = ['name', 'description', 'state'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tbl_role_user', 'role_id', 'user_id')
        ->select('tbl_users.id', 'tbl_users.user_name', 'tbl_users.email');
    }
}
