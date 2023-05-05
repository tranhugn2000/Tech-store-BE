<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|max:191',
            'email' => 'bail|required|email|unique:users,email,NULL,id,deleted_at,NULL|max:191|regex:/^([a-z0-9_-]+)(\.[a-z0-9_-]+)*@([a-z0-9_-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'bail|required|min:8|max:20|regex:/^\S*$/u',
            'password_confirmation' => 'bail|required|same:password',
            'avatar' => 'bail|nullable|mimes:jpeg,png,jpg,gif|max:3072',
            'role' => 'required'
        ];
    }
}
