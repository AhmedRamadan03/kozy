<?php

namespace Modules\Superadmin\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'en.title' => 'required|string|max:150',
            'country_id' => 'required|exists:countries,id',
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
