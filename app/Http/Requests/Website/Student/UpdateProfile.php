<?php

namespace App\Http\Requests\Website\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfile extends FormRequest
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
        $user = auth()->user()->id;
        return [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:50',
            'email' => 'required|string|max:191|email:rfc,dns|unique:users,email,'.$user,
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'city_id' => 'required|exists:cities,id',
            'level_id' => 'required|exists:levels,id',
            'phone' => ['required', 'regex:/^([0-9])/',
                Rule::unique('users', 'phone')->ignore($user),
            ],
        ];
    }
}
