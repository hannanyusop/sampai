<?php

namespace App\Domains\Auth\Http\Requests\Backend\TripRemark;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class InsertTripRemark extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'text' => 'required|max:200',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => 'Please insert your remark',
            'text.max' => 'Only 200 words allowed'
          ];
    }
}
