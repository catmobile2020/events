<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable=['question','speaker_id'];

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
