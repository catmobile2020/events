<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'=>$this->id,
        ];
        if ($this->roomable->email == auth()->user()->email)
        {
            $data['user'] = $this->receiver;
        }else
        {
            $data['user'] = $this->roomable;
        }
        $data['messages'] = MessageResource::collection($this->messages);
        return $data;
    }
}
