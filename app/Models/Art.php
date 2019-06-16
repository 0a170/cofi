<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\Uuids;
use App\User;

class Art extends Model
{   
    use Uuids;

    protected $table = 'art';

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    protected $casts = [
        'id' => 'string'
    ];

    protected $appends = ['likes', 'isLiked'];

    // protected $primaryKey = 'uuid';

    protected $fillable = ['title', 'description', 'src'];  

    /**
     * Relationship for art's owner/creator
     *
     * @return \Illuminate\Http\Response
     */
    public function owner() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Likes
     * 
     * @return \Illuminate\Http\Response
     */
    public function likes() 
    {
        return $this->hasMany(Art::class, 'likes', 'id');
    }

    /**
     * Number of likes on art piece
     * 
     * @return int $likes  
     */
    public function getLikesAttribute()
    {
        return $likes = DB::table('likes')
            ->where('art_id', $this->id)
            ->count();
    }

    /**
     * If authenticated user likes the art piece
     * 
     * @param uuid $userId
     * 
     * @return bool $liked
     */
    public function getIsLikedAttribute($userId) 
    {
        $liked = false;
        if (auth('api')->user()) {
            $like = DB::table('likes')
                ->where('user_id', '=', auth('api')->user()->id)
                ->where('art_id', '=', $this->id)
                ->where('liked', '=', true)
                ->get();

            $liked = $like->count() > 0 ? true : false;
            return $liked;
        }
        return $liked;
    }
}
