<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable=['receive__id','user_type'];

    public function roomable()
    {
        return $this->morphTo();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function receiver()
    {
        if ($this->user_type == 'attendee')
            return $this->belongsTo(User::class,'receive__id')->withDefault();
        return $this->belongsTo(Speaker::class,'receive__id')->withDefault();
    }
}
