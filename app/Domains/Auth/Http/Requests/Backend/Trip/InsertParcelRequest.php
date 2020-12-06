<?php

namespace App\Domains\Auth\Http\Requests\Backend\Trip;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class InsertParcelRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'tracking_no' => 'required|unique:parcels,tracking_no|max:50',
            'receiver_name' => 'max:50',
            'receiver_info' => 'required_without:receiver_name|max:50',
            'remark' => 'max:100'
        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
