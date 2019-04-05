<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreTarget extends FormRequest
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
            "name"    => "required|array|min:1",
            "name.*"  => "required|string|max:190|min:3",
            "max"    => "required|array|min:1",
            "max.*"  => "required|numeric|digits_between:1,10000",
            "percent"    => "required|array|min:1",
            "percent.*"  => "required|numeric|digits_between:1,100",
            //
        ];
    }
}
