<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=['question','was_answered','user_id','speaker_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function speaker()
    {
        return $this->belongsTo(User::class,'speaker_id');
    }

}
