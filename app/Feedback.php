<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable=['note','rate'];

    public function feedbackable()
    {
        return $this->morphTo();
    }
    public function event()
    {
        return $this->morphOne(Event::class,'feedbackable');
    }
}
