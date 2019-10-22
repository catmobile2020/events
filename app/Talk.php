<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    protected $fillable=['name','time','duration','event_id','speaker_id'];

    public function event()
    {
        return $this->belongsTo(Event::class)->withDefault();
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class)->withDefault();
    }
}
