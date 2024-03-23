<?php

namespace Modules\Superadmin\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCountryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp',Rule::requiredIf(function(){ return !isset($this->id);})],
            'ar.title' => 'required|string|max:150',
            'en.title' => 'required|string|max:150',
            'currency' => 'nullable',
            'tax' => 'nullable',
            'shipping' => 'nullable',
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
