<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partnership extends Model
{
    protected $fillable=['name','active'];

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
