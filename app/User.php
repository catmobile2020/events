<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','phone','type', 'active', 'email', 'password',
    ];

    protected $appends=['photo'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to `native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password']=bcrypt($value);
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
                return 'Attendee';
                break;
            default:
                return '';
        }
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

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function posts()
    {
        return $this->morphMany(Post::class,'postable');
    }

    public function ownerPosts()
    {
        return $this->hasManyThrough(Post::class,Event::class);
    }

    public function attendeeEvents()
    {
        return $this->belongsToMany(Event::class);
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
        return $this->hasMany(Question::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class)->latest();
    }

    public function chat()
    {
        return $this->morphMany(Chat::class,'chatable');
    }

    public function messenger()
    {
        return $this->morphMany(Room::class,'roomable');
    }

    public function messages()
    {
        return $this->morphMany(Message::class,'messageable');
    }

}
