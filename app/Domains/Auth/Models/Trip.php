<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model{

    protected $fillable = [];

    public function destination(){
        return $this->hasOne(Office::class, 'id', 'destination_id');
    }

    public function parcels(){
        return $this->hasMany(Parcels::class, 'trip_id', 'id');
    }

    public function transactions(){
        return $this->hasOne(Trip::class, 'id', 'trip_id');
    }

    public function remarks(){

        return $this->hasMany(TripRemark::class, 'trip_id', 'id');
    }
}
