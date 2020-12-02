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
            'remark' => 'max:255'
        ];
    }
}
