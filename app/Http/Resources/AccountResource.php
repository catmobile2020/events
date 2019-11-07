<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'name'=>$this->name,
            'username'=>$this->username,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'photo'=>$this->photo,
            'active'=>(boolean)$this->active,
            'type'=>$this->type_name,
        ];
    }
}
