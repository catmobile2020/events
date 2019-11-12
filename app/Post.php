<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=['desc','event_id'];

    public function postable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'postable_id');
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class,'postable_id');
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
        $this->comments()->delete();
        $this->delete();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

}
