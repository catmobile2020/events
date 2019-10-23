<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'date'=>$this->date,
            'desc'=>$this->desc,
            'contact_phone'=>$this->contact_phone,
            'contact_email'=>$this->contact_email,
            'address'=>$this->address,
            'have_ticket'=>(boolean)$this->have_ticket,
            'active'=>(boolean)$this->active,
            'is_public'=>(boolean)$this->is_public,
            'owner'=>AccountResource::make($this->user),
            'speakers'=>SpeakerResource::collection($this->activeSpeakers()->get()),
            'logo'=>$this->logo,
            'cover'=>$this->cover,
        ];
    }
}
