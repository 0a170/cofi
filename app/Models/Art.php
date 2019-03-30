<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Art extends Model
{   
    use Uuids;

    protected $table = 'art';

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

    protected $casts = [
        'id' => 'string'
    ];

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
}
