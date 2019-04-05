<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeeting extends FormRequest
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
            'time' => 'required|string|max:190',
            'date' => 'required|string|max:190',
            'client_name' => 'required|string|max:190',
            'person_name' => 'required|string|max:190',
            'person_number' => 'required|numeric|digits_between:3,15',
            'address' => 'required|string|max:500',
            'result' => 'required|string|max:190||in:Quoted,Order,Request,Canceled',
            'reason' => 'required_if:result,==,Cancelled|sometimes|nullable|string|max:4000',
            //
        ];
    }
}
