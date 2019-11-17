<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable=['sender_id','receive__id'];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id')->withDefault();
    }
    public function receive()
    {
        return $this->belongsTo(User::class,'receive__id')->withDefault();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
