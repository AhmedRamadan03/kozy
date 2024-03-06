<?php

namespace Modules\Superadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreColorAndSizeRequest extends FormRequest
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
            'name' => ['required','string'],
            'value' => ['required'],

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
