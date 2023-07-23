<?php

namespace App\Http\Requests\Frontend\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParcelRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "receiver_name" => "required|max:200",
            "phone_number"  => "required|max:20",
            "tracking_no"   => "required|unique:parcels,tracking_no,{$this->id}|max:50",
            "description"   => "required|max:250",
            "quantity"      => "required|numeric|min:1",
            "price"         => "required|numeric",
//            "tax"           => "required|numeric",
            "invoice_url"   => "nullable|file|max:20048",
            "office_id"     => "required|exists:offices,id",
        ];
    }
}
