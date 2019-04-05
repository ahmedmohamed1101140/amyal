<?php

namespace App\Http\Requests\Site;

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
        if($this->hasFile('file-upload1')){
            return [
                'file-upload1' => 'required|max:15|mimes:csv,xlsx,xls'
            ];
        }
        $cities = array_map(function($var)
        {
            return (string)$var;
        }, array_column(auth()->user()->shipping_fees->toArray(),'city_id'));


        return [
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'cod' => 'required|numeric|min:0|max:1000000',
            'security_number' => 'required|numeric|min:0',
            'receiver_name' => 'required|string|max:190',
            'city_id' => 'required|string|max:255|in:'.implode(",", $cities),
            'area_id' => 'required|string|max:255|exists:areas,id',
            'address' => 'required|string|max:400',
            'mark_place' => 'required|string|max:400',
            'mobile' => 'required|numeric|digits_between:3,15',
        ];
    }
}
