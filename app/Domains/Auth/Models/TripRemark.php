<?php

namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;


class TripRemark extends Model
{

    protected $fillable  = [
        'trip_id',
        'user_id',
        'text'
    ];

    public function trip(){
        return $this->hasOne(Trip::class,'id', 'trip_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
