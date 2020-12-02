<?php

namespace App\Http\Requests\Frontend\User\Subscribe;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{

    public function authorize(){

        return true;
    }


    public function rules()
    {
        return [
            'tracking_no' => 'required|max:50',
            'remark' => 'max:255'
        ];
    }
}
