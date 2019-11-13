<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=['body','room_id'];

    public function messageable()
    {
        return $this->morphTo();
    }

    public function room()
    {
        return $this->belongsTo(Room::class)->withDefault();
    }
}
