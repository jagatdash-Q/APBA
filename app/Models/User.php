<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements LaratrustUser
{
    use HasFactory, HasRolesAndPermissions, Notifiable;
    // The User model requires this trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', '2fa_status', 'google2fa_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'name' => 'encrypted',
        'google2fa_secret' => 'encrypted',
    ];

    public function getRole(): HasOne
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id')->with('getRoleDetails');
    }

}
