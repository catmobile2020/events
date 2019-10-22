<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SpeakerRequest extends FormRequest
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
            'phone' => 'required|max:191|unique:users,phone',
            'email' => 'required|email|unique:users,email',
        ];

        if ($this->routeIs('admin.speakers.store') or $this->request->get('password') != null)
        {
            $data['password']='required|confirmed|min:6';
        }

        return $data;
    }
}
