<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
    protected $primaryKey = 'uuid';

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
