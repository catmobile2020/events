<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'info'=>$this->data['notify']['info'],
            'url'=>$this->data['notify']['url'],
            'created_at'=>$this->created_at->diffForHumans(),
        ];
    }
}
