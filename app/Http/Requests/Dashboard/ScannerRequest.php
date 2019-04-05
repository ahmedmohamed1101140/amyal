<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ScannerRequest extends FormRequest
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
            'trackingNumber' => 'required',
            'status' => 'string|in:Received,Out for delivery,Transfer To,Back to shipper,Incorrect Phone,Incorrect Address',
            'delivery_id' => 'required_if:type,==,Out for delivery|nullable|exists:agents,id',
            'office_id' => 'required_if:type,==,Transfer To|nullable|exists:offices,id',
            'pickup_id' => 'required_if:type,==,Back to shipper|nullable|exists:agents,id',
        ];
    }
}
