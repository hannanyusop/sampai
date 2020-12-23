<?php

namespace App\Domains\Auth\Http\Requests\Backend\Office;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class StoreUserRequest.
 */
class InsertOfficeRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'code' => 'required|unique:offices,code|min:3|max:5',
            'name' => 'required|max:50',
            'is_drop_point' => '',
            'address' => '',
            'location' => '',
            'operation_day' => '',

        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
