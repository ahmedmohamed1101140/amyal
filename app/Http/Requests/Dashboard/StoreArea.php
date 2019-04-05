<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreArea extends FormRequest
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
                    'name' => 'required|string|max:190|unique:areas,name',
                    'city_id' => 'required|string|exists:cities,id'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:190|unique:areas,name,'.$this->area_id,
                    'city_id' => 'required|string|exists:cities,id'
                ];
            }
            default:break;
        }
    }
}
