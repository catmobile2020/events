<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
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
            'owner'=>AccountResource::make($this->user),
            'logo'=>$this->logo,
            'cover'=>$this->cover,
        ];
    }
}
