<?php

namespace App\Http\Requests\Dashboard;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
                    'name' => 'required|string|max:190',
                    'phone' => 'required|numeric|digits_between:3,15|unique:agents,phone',
                    'email' => 'required|email|max:190|unique:agents,email',
                    'address' => 'required|string|max:500',
                    'password' => 'required|string|min:6|confirmed',
//                    'age' => 'required|date|before:1/1/2008',
                    'age' => 'required',
                    'GOV_number' => 'required|numeric|digits_between:12,15|unique:agents,ssn',
                    'office_id' => 'required|exists:offices,id',
//                    'join_date' => 'required|date|after:1/1/2018',
                    'join_date' => 'required',
                    'department_id' => 'required|exists:departments,id',
                    'type' => 'string|in:Employee,Sales Person,Pickup Agent,Delivery Agent',
                    'position' => 'required_if:type,==,Employee|sometimes|nullable|string|max:190',
                    'shift_from' => 'required',
                    'shift_to' => 'required',
                    'city_id' => 'required|exists:cities,id',
                    'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:50000',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:190',
                    'phone' => 'required||numeric|digits_between:3,15|unique:agents,phone,'.$this->agent_id,
                    'email' => 'required|email|max:190|unique:agents,email,'.$this->agent_id,
                    'address' => 'required|string|max:500',
                    'age' => 'required',
                    'GOV_number' => 'required|numeric|digits_between:13,15|unique:agents,ssn,'.$this->agent_id,
                    'office_id' => 'required|exists:offices,id',
                    'join_date' => 'required',
                    'department_id' => 'required|exists:departments,id',
                    'position' => 'required_if:type,==,Employee|sometimes|nullable|string|max:190',
                    'shift_from' => 'required',
                    'shift_to' => 'required',
                    'city_id' => 'required|exists:cities,id',
                    'image' => 'image|mimes:jpeg,jpg,png,gif|max:50000',
                ];
            }
            default:break;
        }


    }

    public function messages()
    {
        return [
            'GOV_number.required' => 'Please Enter Government number',
            'GOV_number.digits_between' => 'Government number should be between 13 to 15',
            'GOV_number.numeric' => 'Government number should be anumber',
            'GOV_number.unique' => 'Government number already exist',
        ];
    }
}
