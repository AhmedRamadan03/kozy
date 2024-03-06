<?php

namespace Modules\Superadmin\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAboutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', Rule::requiredIf(function(){ return isset($this->id);})],
            'ar.title' =>'required|string|max:255',
            // 'en.title' =>'required|string|max:255',
            'ar.short_description' =>'required|string',
            // 'en.short_description' =>'required|string',
            'ar.description' =>'nullable|string',
            //'en.description' =>'nullable|string',
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
