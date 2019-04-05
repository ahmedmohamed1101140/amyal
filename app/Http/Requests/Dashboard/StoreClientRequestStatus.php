<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequestStatus extends FormRequest
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
                    'application_id' => 'required|string|max:255|exists:client_requests,id',
                    'agent_id' => 'required|string|max:255|exists:agents,id',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'status' => 'required|string|in:Accepted,Rejected,Open',
                    'action' => 'required|string|max:4000'
                ];
            }
            default:break;
        }
    }
}
