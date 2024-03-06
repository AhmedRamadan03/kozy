<?php

namespace Modules\Superadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp',Rule::requiredIf(function(){ return !isset($this->id);})],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'ar.title' => 'required|string|max:150',
            'en.title' => 'required|string|max:150',
            'country_id' => 'nullable|integer|exists:countries,id',
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
