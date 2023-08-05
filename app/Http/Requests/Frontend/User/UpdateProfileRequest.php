<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
//            'identification' => ['required', 'string','min:5', 'max:20', Rule::unique('users')->ignore($this->user()->id)],
            'phone_number' => ['required',  'regex:/^6\d*$/','min:9', 'max:15', Rule::unique('users')->ignore($this->user()->id)],
//            'address' => ['required', 'min:6', 'max:150'],
            'email' => [Rule::requiredIf(function () {
                return config('boilerplate.access.user.change_email');
            }), 'max:255', 'email', Rule::unique('users')->ignore($this->user()->id)],
        ];
    }

    public function messages()
    {
        return [
            'phone_number.regex' => 'The phone number must start with 6 and contain a maximum of 10 numbers.',
        ];
    }
}
