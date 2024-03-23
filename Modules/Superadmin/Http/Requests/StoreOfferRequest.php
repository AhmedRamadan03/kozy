<?php

namespace Modules\Superadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOfferRequest extends FormRequest
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
        $inputs = [
            'image' => 'nullable',
            'product_id' => ['required','exists:products,id'],
           'start_date' => ['required' , 'before_or_equal:end_date'],
           'end_date' => ['required', 'after_or_equal:start_date'],
           'country_id' => ['required','exists:countries,id'],
        ];



        return $inputs;
    }
}
