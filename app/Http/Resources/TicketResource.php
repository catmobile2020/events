<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'code' =>$this->code,
            'method_type' =>$this->method_type_name,
            'active' =>(boolean)$this->active,
            'event' =>EventsResource::make($this->event),
        ];
    }
}
