<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreCall extends FormRequest
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
            'date' => 'required|string|max:190',
            'time' => 'required|string|max:190',
        ];
    }
}
