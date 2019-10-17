<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getFullUrlAttribute()
    {
        return asset($this->url);
    }

}
