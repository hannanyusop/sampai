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
            'code' => 'required|min:3|max:5|unique:offices,code,'.$this->id,
            'name' => 'required|max:50',
            'is_drop_point' => '',
            'address' => '',
            'location' => '',
            'operation_day' => '',

        ];
    }
}
