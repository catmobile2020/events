<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'comments'=>CommentResource::collection($this->comments),
            'num_comments'=>$this->comments()->count(),
            'photo'=>$this->photo,
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
