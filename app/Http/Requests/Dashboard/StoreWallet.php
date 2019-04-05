<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreWallet extends FormRequest
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
            'record_number' => 'nullable|numeric',
            'payment_method' => 'required|string|max:191',
            'receiver_name' => 'required|string|max:191',
            'amount' => 'required|numeric|min:0',
            'date' => 'required',
            'account_number' => 'required|string|max:255|exists:users,account_number'
        ];
    }
}
