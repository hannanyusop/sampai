<?php

namespace App\Domains\Auth\Http\Requests\Backend\Setting;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class UpdateSystemRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'allow_registration' => '',
            'show_tracking' => '',
        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
