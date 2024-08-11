<?php

namespace App\Domains\Auth\Http\Requests\Backend\Office;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

/**
 * Class StoreUserRequest.
 */
class UpdateOfficeRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->canAny(['admin.access.user', 'staff.manager']);
    }


    public function rules()
    {
        return [
            'code' => 'required|unique:offices,code,'.$this->id.'|min:1|max:5',
            'name' => 'required|max:50',
            'is_drop_point' => '',
            'address' => '',
            'location' => '',
            'operation_day' => '',
            'whatsapp_template' => '',
            'pickup_remark' => ''
        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
