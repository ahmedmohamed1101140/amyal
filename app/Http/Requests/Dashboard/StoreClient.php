<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
                    'company_name' => 'required|string|max:190',
                    'phone' => 'required|numeric|digits_between:3,15|unique:users,phone',
                    'city_id' => 'required|exists:cities,id',
                    'email' => 'required|email|unique:users,email',
                    'address' => 'required|string|max:500',
                    'pickup_address' => 'required|string|max:500',
                    'cp_name' => 'required|string|max:190',
                    'cp_phone' => 'required|numeric|digits_between:3,15',
                    'office_id' => 'required|exists:offices,id',
                    'agent_id' => 'required|exists:agents,id',
                    'password' => 'required|string|min:6|confirmed',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'company_name' => 'required|string|max:190',
                    'phone' => 'required|numeric|digits_between:3,15|unique:users,phone,'.$this->client_id,
                    'city_id' => 'required|exists:cities,id',
                    'email' => 'required|email|max:190|unique:users,email,'.$this->client_id,
                    'address' => 'required|string|max:500',
                    'pickup_address' => 'required|string|max:500',
                    'cp_name' => 'required|string|max:190',
                    'cp_phone' => 'required|numeric|digits_between:3,15',
                    'office_id' => 'required|exists:offices,id',
                    'agent_id' => 'required|exists:agents,id',
                    'status' => 'string|in:Active,Suspend',
                    'action' => 'required_if:status,==,Suspend|sometimes|nullable|string|max:400'
                ];
            }
            default:break;
        }
    }
}
