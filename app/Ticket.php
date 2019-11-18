<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable=['code','method_type','active','event_id','user_id'];

    public function event()
    {
        return $this->belongsTo(Event::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function getMethodTypeNameAttribute()
    {
        switch ($this->method_type)
        {
            case 1:
                return 'cash';
                break;
            case 2:
                return 'credit';
                break;
            default:
                return '';
        }
    }
}
