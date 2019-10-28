<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=['desc','user_type','user_id','speaker_id','post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function owner()
    {
        if ($this->user_type == 'speaker')
        {
            return $this->belongsTo(Speaker::class,'speaker_id');
        }
        return $this->belongsTo(User::class,'user_id');
    }

}
