<?php

namespace App\Http\Requests\Website\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChangePassword extends FormRequest
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
            'old_password' => 'required',
            'new_password' => 'required|max:191|min:6|different:old_password',
            'confirm_new_password'=> 'required|min:6|max:191|same:new_password'
        ];
    }
}
