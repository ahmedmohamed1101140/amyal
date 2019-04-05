<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StorePickupRequest extends FormRequest
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
            //
            'account_number' => 'required|string|max:255|exists:users,account_number'
        ];
    }
}
