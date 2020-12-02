<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Parcels extends Model{

    protected $fillable = [];

    public function trip(){
        return $this->hasOne(Trip::class, 'id', 'trip_id');
    }

    public function transactions(){

        return $this->hasMany(ParcelTransaction::class, 'parcel_id', 'id');
    }
}
