<?php

namespace App\Domains\Auth\Http\Requests\Backend\Parcel;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class CompleteRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'pickup_name' => 'required|max:50',
            'pickup_info' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
