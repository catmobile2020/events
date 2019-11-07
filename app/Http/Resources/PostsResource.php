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
            'comments'=>CommentResource::collection($this->comments()->take(2)->get()),
            'num_comments'=>$this->comments()->count(),
            'photo'=>$this->photo,
        ];
        if ($this->speaker)
        {
            $data['type'] = 'speaker';
            $data['user'] = SpeakersResource::make($this->speaker);
        }else
        {
            $data['type'] = 'attendee';
            $data['user'] = AccountResource::make($this->user);
        }

        return $data;
    }
}
