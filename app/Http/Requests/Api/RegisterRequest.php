<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
        $roles = [
            'name' => 'required',
        ];

        $user_id = auth()->id();
        $table = 'users';
        if (request()->header('type') == 2)
        {
            $table = 'speakers';
        }
        if ($this->routeIs('api.account.update'))
        {
            $roles +=['phone' => "required|unique:{$table},phone,{$user_id}"];
            $roles +=['email' => "required|unique:{$table},email,{$user_id}"];
        }

        if ($this->routeIs('api.register'))
        {
            $roles +=['phone' => "required|unique:{$table},phone"];
            $roles +=['email' => "required|unique:{$table},email"];
            $roles +=['password' => 'required|min:6'];
        }
        return  $roles;
    }

    protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => $validator->errors()->all()];

        throw new HttpResponseException(response()->json($result , 400));
    }
}
