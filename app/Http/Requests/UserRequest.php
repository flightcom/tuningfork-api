<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        error_log('ID : '.$this->user);

        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user),
            ],
            'phone' => [
                Rule::unique('users')->ignore($this->user),
            ],
            'birth_date' => 'required|date',
            'password' => 'confirmed',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
