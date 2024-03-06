<?php

namespace Modules\Superadmin\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:3',
            'image' => ['nullable', 'image' , 'mimes:jpeg,png,jpg'],
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($this->id)],
            'phone' => ['required', Rule::unique('admins', 'email')->ignore($this->id)],
            'password' => ['nullable', 'string' , 'min:6' , Rule::requiredIf(function(){ return !isset($this->id);})],
            'role_id' => 'required|numeric|exists:roles,id',
            'country_id' => 'required|numeric|exists:countries,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
