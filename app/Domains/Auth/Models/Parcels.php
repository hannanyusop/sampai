<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Parcels extends Model{

    protected $fillable = ['trip_id'];

    public function trip(){
        return $this->hasOne(Trip::class, 'id', 'trip_id');
    }

    public function transactions(){

        return $this->hasMany(ParcelTransaction::class, 'parcel_id', 'id')->orderBy('id', 'DESC');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function lastTransaction(){
        return $this->hasOne(ParcelTransaction::class, 'parcel_id', 'id')->orderBy('id', 'DESC');
    }

    public function dropPoint(){

        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function getStatusLabelAttribute(){
        return getParcelStatus($this->status);
    }
}
