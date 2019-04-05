<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreCity extends FormRequest
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
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'name' => 'required|string|max:190|unique:cities,name',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:190|unique:cities,name,'.$this->city_id,
                ];
            }
            default:break;
        }
    }


}
