<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\Traits\Uuids;


class User extends Authenticatable
{
    use Uuids, HasApiTokens, Notifiable;

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    protected $casts = [
        'id' => 'string'
    ];

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
        return $this->hasMany(\App\Models\Art::class);
    }

    /**
     * Number of likes
     * 
     * @return int $likes
     */
    public function likes()
    {
        // return $this->belongsToMany(User::class, 'likes', 'art_id', 'user_id');
        return $this->belongsToMany(User::class, 'likes');
    }
}
