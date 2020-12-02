<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class TripTransaction extends Model{

    protected $fillable = [];

    public function trip(){
        return $this->hasOne(Trip::class, 'id', 'trip_id');
    }
}
