<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StorePickupRequestStatus extends FormRequest
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
            'status' => 'required|string|in:Assign To,Cancel,Done',
            'agent_id' => 'nullable|string|max:255|exists:agents,id',
        ];
    }
}
