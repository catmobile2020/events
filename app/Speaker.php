<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Speaker extends Authenticatable  implements JWTSubject
{
    use Notifiable;
    protected $fillable=['name','phone','email','bio','enable_questions','active','password','event_id'];

    protected $appends=['photo'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password']=bcrypt($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function event()
    {
        return $this->belongsTo(Event::class)->withDefault();
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable')->withDefault([
            'url'=>'assets/admin/images/default-avatar.png'
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

    public function talks()
    {
        return $this->hasMany(Talk::class);
    }

    public function posts()
    {
        return $this->morphMany(Post::class,'postable');
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class)->withPivot(['notes']);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->latest();
    }

    public function chat()
    {
        return $this->morphMany(Chat::class,'chatable');
    }

    public function messenger()
    {
        $type = $this->type ? 'attendee' : 'speaker';
        return $this->morphMany(Room::class,'roomable');
    }
}
