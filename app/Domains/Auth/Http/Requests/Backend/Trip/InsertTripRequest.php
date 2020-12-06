<?php

namespace App\Domains\Auth\Http\Requests\Backend\Trip;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class InsertTripRequest extends FormRequest
{

    public function authorize(){

        return auth()->user()->isAdmin();
    }


    public function rules()
    {
        return [
            'destination_id' => 'required|in:'.implode(',', Office::where('is_drop_point', 1)->pluck('id')->toArray()).'|not_in:'.implode(Trip::where('status', 0)->pluck('destination_id')->toArray()),
//            'date' => 'required|date',
            'remark' => 'max:255'
        ];
    }

    public function messages()
    {
        return [
          ];
    }
}
