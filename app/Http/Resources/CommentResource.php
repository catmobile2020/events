<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'type'=>$this->user_type,
        ];
        if ($this->user_type == 'speaker')
        {
            $data['user'] = SpeakersResource::make($this->owner);
        }else
        {
            $data['user'] = AccountResource::make($this->owner);
        }
        return $data;
    }
}
