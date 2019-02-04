<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\BinaryUuid\HasBinaryUuid;

class User extends Authenticatable
{
    use Notifiable, HasBinaryUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship for user's art
     *
     * @return \Illuminate\Http\Response
     */
    public function artwork() 
    {
        return $this->hasMany(Art::class);
    }
}
