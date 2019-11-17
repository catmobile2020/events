<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'event_id'=>$this->event_id,
            'message'=>$this->message,
            'created_at'=>$this->created_at->diffForHumans(),
            'user'=>$this->user,
        ];
    }
}
