<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $data = [
            'name' => 'required|max:191',
        ];

        if ($this->routeIs('admin.users.update'))
        {
            $data['phone']='required|max:191|unique:attendees,phone,'.$this->user()->id;
            $data['email']='required|email|unique:attendees,email,'.$this->user()->id;
        }else
        {
            $data['phone']='required|max:191|unique:attendees,phone';
            $data['email']='required|email|unique:attendees,email';
            $data['password']='required|confirmed|min:6';
        }
        return $data;
    }
}
