<?php

namespace Modules\Website\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cart' => 'required|array',
            'cart.product_id' => 'required|exists:products,id',
            'cart.color_id' => 'nullable|exists:colors,id',
            'cart.size_id' => 'nullable|exists:sizes,id',
            'cart.quantity' => 'required|numeric|min:1',
            'cart.price' => 'required|numeric',
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
