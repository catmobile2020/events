<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data =[
            'name'=>'required',
            'time'=>'required',
            'desc'=>'required',
            'contact_phone'=>'required',
            'contact_email'=>'required',
            'address'=>'required',
            'have_ticket'=>'required',
            'map_link'=>'required',
        ];
        if ($this->routeIs('admin.events.update'))
        {
            $data['logo']='image';
            $data['cover']='image';
        }else
        {
            $data['logo']='required|image';
            $data['cover']='required|image';
        }
        return $data;
    }
}
