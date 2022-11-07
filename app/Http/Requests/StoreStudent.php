<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:App\Models\Student',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits:10',
            'gender' => 'required',
            'identification' => 'required',
            'address' => 'required',
        ];
    }
}
