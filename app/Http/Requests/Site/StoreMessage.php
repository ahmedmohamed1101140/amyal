<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessage extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'nullable|string|max:4000',
            'attachment' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:200000'
        ];

    }
}
