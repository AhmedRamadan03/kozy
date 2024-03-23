<?php

namespace Modules\Website\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "string|min:10|required",
            "phone" => "required",
            // "neighborhood" => "required",
            "street" => "required",
            "district" => "required",
            "postal_code" => "required",
            "payment_method" => "required",
            "notes" => "nullable",
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
