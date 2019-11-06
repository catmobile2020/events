<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpeakerResource extends JsonResource
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
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'bio'=>$this->bio,
            'talks'=>TalkResource::collection($this->talks),
            'photo'=>$this->photo,
            'enable_questions'=>(boolean)$this->enable_questions,
            'event'=>EventsResource::make($this->event),
        ];
    }
}
