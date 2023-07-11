<?php

namespace App\Http\Requests\Frontend\Parcel;

use Illuminate\Foundation\Http\FormRequest;

class StoreParcelRequest extends FormRequest
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
            "description"   => "required|max:500",
            "quantity"      => "required|numeric|min:1",
            "price"         => "required|numeric",
            "invoice_url"   => "required|file|max:20048",
            "order_origin"  => "required|max:50",
            "office_id"     => "required|exists:offices,id",
        ];
    }

    public function messages()
    {
        return [
            'invoice_url.max' => 'The invoice may not be greater than 20 MB.',
            'invoice_url.file' => 'The invoice must be a file.',
            'invoice_url.required' => 'Please upload invoice.',

            'office_id.required' => 'Please select drop point.'
        ];
    }
}
