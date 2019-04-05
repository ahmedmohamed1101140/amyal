<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreRole extends FormRequest
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
            "agent_id" => 'required||exists:agents,id',
            "permission"    => "required|array|min:1",
            "permission.*"  => "required|string|exists:permissions,id",
        ];
    }
}
