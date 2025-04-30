<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profiles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'tbl_users';

    protected $fillable = [
        'user_name',
        'email',
        'user_pass',
        'published',
        'id_membership',
        'membership_status',
        'user_rating',
        'remenber_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'user_pass',
        'remenber_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'user_pass' => 'hashed',
        ];
    }

    //Parte donde se trabaja la realción 
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'tbl_role_user', 'user_id', 'role_id');
    }

        
    //Verifica si el usuario tiene un rol específico.
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('name', $roleName);
    }
    public function profile()
    {
        return $this->hasOne(Profiles::class, 'id_user', 'id');
    }
    public function membership()
    {
        return $this->belongsTo(Memberships::class, 'id_membership', 'id');
    }

    //Parte donde se trabaja lo de seguidores
    //Verifica los Usuarios que yo sigo
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    //Verifica los Usuarios que me siguen
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    // Verifica si el usuario ya sigue a otro usuario
    public function isFollowing(User $user)
    {
        return $this->following->contains($user);
    }

    // Verifica si el usuario es seguido por otro usuario
    public function isFollowedBy(User $user)
    {
        return $this->followers->contains($user);
    }

}
