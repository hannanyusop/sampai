<?php

namespace App\Http\Requests\Frontend\User\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class TopupRequest extends FormRequest
{

    public function authorize(){

        return true;
    }


    public function rules()
    {
        return [
            'amount' => 'numeric|required|min:5',
        ];
    }
}
