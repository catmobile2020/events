<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable=['question'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
