<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        $data= [
            'active'=>'required',
        ];
        if ($this->routeIs('admin.banners.update'))
        {
            $data['photo']='image';
        }else
        {
            $data['photo']='required|image';
        }
        return $data;
    }
}
