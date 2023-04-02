<?php

namespace App\Http\Requests\Backend\UnregisteredParcel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnregisteredParcel extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "tracking_no"   => "required|unique:parcels,tracking_no|max:50",
            "receiver_name" => "required|max:100",
            "phone_number"  => "required|max:20",
            "order_origin"  => "required|max:500",
            "address"       => "required|max:500",
            "remark"        => "required|max:500",
        ];
    }
}
