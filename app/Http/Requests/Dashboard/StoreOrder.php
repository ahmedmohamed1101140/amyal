<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'cod' => 'required|numeric|min:0',
            'shipping_fees' => 'required|numeric|min:0|max:100000',
            'security_number' => 'required|numeric|min:0',
            'receiver_name' => 'required|string|max:190',
            'city_id' => 'required|string|max:255|exists:cities,id',
            'area_id' => 'required|string|max:255|exists:areas,id',
            'address' => 'required|string|max:4000',
            'mark_place' => 'required|string|max:4000',
            'mobile' => 'required|numeric|digits_between:3,15',
        ];
    }
}
