<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable=['message','event_id'];

    public function chatable()
    {
        return $this->morphTo();
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'url'=>'assets/admin/images/default-image.jpg'
        ]);
    }
    public function getPhotoAttribute()
    {
        return $this->image->full_url;
    }

    public function trash()
    {
        $photo = public_path().$this->image->url;
        if (is_file($photo))
        {
            @unlink($photo);
            $this->image()->delete();
        }
        $this->delete();
    }
}
