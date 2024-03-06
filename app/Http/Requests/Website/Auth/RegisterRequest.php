<?php

namespace App\Http\Requests\Website\Auth;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'level_id' => ['required', 'numeric' , 'exists:levels,id'],
            'city_id' => ['required', 'numeric' , 'exists:cities,id'],
            'group_id' => ['required', 'numeric' , 'exists:groups,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric', 'digits:11', 'unique:users'],
            'father_phone' => ['nullable', 'numeric', 'digits:11', 'unique:fathers,phone','different:phone'],
        ];
    }
}
