<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=['body'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function room()
    {
        return $this->belongsTo(Room::class)->withDefault();
    }
}
