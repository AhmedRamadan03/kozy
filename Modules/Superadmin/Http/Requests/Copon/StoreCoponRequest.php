<?php

namespace Modules\Superadmin\Http\Requests\Copon;

use App\Models\Copon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd(implode(',', Copon::DISCOUNT_TYPES), request()->all());
        return [
            'code' => ['required','string',Rule::unique('copons', 'code')->ignore($this->id)],
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:'.implode(',', Copon::DISCOUNT_TYPES),
            'expired_at' => 'required|date|after:'.date('Y-m-d'),
            'is_free' => 'nullable|boolean',
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
