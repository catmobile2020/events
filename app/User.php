<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'active'
    ];

    protected $appends=['photo'];
    protected $with=['user'];

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

    public function getActiveNameAttribute()
    {
        if ($this->active)
        {
            return 'Activated';
        }
        return 'Deactivated';
    }

    public function getTypeNameAttribute()
    {
        switch ($this->type)
        {
            case 0 :
                return 'Admin';
                break;
            case 1 :
                return 'Event Owner';
                break;
            case 2 :
                return 'Speaker';
                break;
            case 3 :
                return 'Attendee';
                break;
            default:
                return '';
        }
    }

    public function user()
    {
        if ($this->type == 2)
        {
            return $this->hasOne(Speaker::class);
        }
        return $this->hasOne(Attendee::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function ownerPosts()
    {
        return $this->hasManyThrough(Post::class,Event::class);
    }

    public function attendeeEvents()
    {
        return $this->belongsToMany(Event::class);
    }

    public function talks()
    {
        return $this->hasMany(Talk::class);
    }

    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class)->withPivot(['notes']);
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public function partnerships()
    {
        return $this->hasMany(Partnership::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->latest();
    }

    public function chat()
    {
        return $this->hasMany(Chat::class);
    }

    public function messenger()
    {
        return $this->hasMany(Room::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

}
