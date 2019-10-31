<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable=['answer','poll_id'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
