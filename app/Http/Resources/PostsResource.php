<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data =[
            'id'=>$this->id,
            'desc'=>$this->desc,
        ];
        if ($this->speaker)
        {
            $data['type'] = 'speaker';
            $data['user'] = SpeakerResource::make($this->speaker);
        }else
        {
            $data['type'] = 'attendee';
            $data['user'] = AccountResource::make($this->user);
        }

        return $data;
    }
}
