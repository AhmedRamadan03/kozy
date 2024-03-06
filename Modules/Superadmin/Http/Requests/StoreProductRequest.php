<?php

namespace Modules\Superadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Astrotomic\Translatable\Validation\RuleFactory;

class StoreProductRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
            'brand_id' => [
                'required',
                'integer',
                Rule::exists('brands', 'id'),
            ],
            'price' => 'required|numeric|max:1000000',
            'discount' => 'required|numeric|max:' . $this->price,
            'after_discount' => 'nullable',
            'quantity' => 'required|integer|min:0|max:10000000',

            'hide' => 'required|in:1,0',

            'image' => [
                'nullable',
                'mimes:jpeg,jpg,png,gif.wepb',
                'max:5000',
                Rule::requiredIf(function () {return !(isset($this->id));}),
            ],

            'en.title' => ['required', 'string', 'max:191', 'min:3'],
            'en.short_description' => 'required|string|max:600',
            'en.description' => 'nullable|string',
            'en.meta_keywords' => 'nullable|string|max:600',
            'en.meta_description' => 'nullable|string|max:600',

            'ar.title' => ['required', 'string', 'max:191', 'min:3'],
            'ar.short_description' => 'required|string|max:600',
            'ar.description' => 'nullable|string',
            'ar.meta_keywords' => 'nullable|string|max:600',
            'ar.meta_description' => 'nullable|string|max:600',

            'images' => ['nullable', 'array'],
            'sku' => ['nullable', 'string'],
            'images.*' => 'mimes:jpeg,jpg,png,wepb',

            
            'attributes' => 'nullable|array',
            // 'buy_price' => 'required|numeric',
            // 'shipping_fee' => 'nullable',
            // 'rate' => 'nullable',
            // 'sales' => 'nullable',
        ];
        return RuleFactory::make($rules);
    }

    public function attributes()
    {
        return [
            'hide' => __('lang.status'),
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->merge([
            'after_discount' => $this->price - $this->discount,
        ]);
        return $data;
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
