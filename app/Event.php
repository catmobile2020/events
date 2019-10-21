<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=['name','time','desc','contact_phone','contact_email','address','map_link','active','user_id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function getActiveNameAttribute()
    {
        if ($this->active)
        {
            return 'Activated';
        }
        return 'Deactivated';
    }

    public function image()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getLogoAttribute()
    {
        return $this->image()->where('type','=','logo')->first()->full_url ?? asset('assets/admin/images/default-image.jpg');
    }

    public function getCoverAttribute()
    {
        return $this->image()->where('type','=','cover')->first()->full_url ?? asset('assets/admin/images/default-image.jpg');
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
