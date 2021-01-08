<?php

namespace App\Http\Requests\Frontend\User\Subscribe;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize(){

        return true;
    }


    public function rules()
    {
        return [
            'tracking_no' => 'required|max:50',
            'remark' => 'required|max:255'
        ];
    }
}
