<?php

namespace App\Domains\Auth\Http\Requests\Backend\Setting;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class UpdatePaymentRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'payment_enabled' => '',
            'payment_cost' => 'required|numeric|min:0.01',
            'payment_limit_query' => 'required|numeric',
            'payment_limit_top_up' => 'required|numeric|min:1',
            'payment_collection_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
