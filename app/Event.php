<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=['name','date','desc','contact_phone','contact_email','address','map_link','active','have_ticket','is_public','invitation_code','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
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

    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }

    public function activeSpeakers()
    {
        return $this->speakers()->where('active','=',1);
    }

    public function talks()
    {
        return $this->hasMany(Talk::class);
    }

    public function scopeAvailable($q)
    {
        return $q->where('active',1)->where('is_public',1);
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'event_id')->latest();
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class)->latest();
    }

    public function activeTestimonials()
    {
        return $this->testimonials()->where('active','=',1);
    }

    public function feedback()
    {
        return $this->morphMany(Feedback::class,'feedbackable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function polls()
    {
        return $this->hasManyThrough(Poll::class,Speaker::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }
    public function activeSponsors()
    {
        return $this->sponsors()->where('active','=',1);
    }

    public function partnerships()
    {
        return $this->belongsToMany(Partnership::class);
    }

    public function activePartnerships()
    {
        return $this->partnerships()->where('active','=',1);
    }

    public function messages()
    {
        return $this->hasMany(Chat::class,'event_id')->latest();
    }
}
