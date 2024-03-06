<?php

namespace Modules\Superadmin\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ar.title' => 'required|string|max:150',
            // 'en.title' => 'required|string|max:150',
            'ar.description' => 'nullable|string',
            //'en.description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
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
