<?php

namespace Modules\Superadmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoRequest extends FormRequest
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
            'subject' => 'required|string|max:150',
            'task' => 'required',
            'user_id' => 'nullable|integer|exists:admins,id',
            'end_date' => 'required|date',
            'status' => 'nullable',
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
