<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    protected $fillable=['name','time','duration','user_id'];

    public function event()
    {
        return $this->belongsTo(Event::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function feedback()
    {
        return $this->morphMany(Feedback::class,'feedbackable');
    }
}
