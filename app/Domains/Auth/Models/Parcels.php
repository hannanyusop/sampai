<?php
namespace App\Domains\Auth\Models;

use App\Models\Pickup;
use Illuminate\Database\Eloquent\Model;

class Parcels extends Model{

    protected $fillable = ['pickup_id', 'status'];

    public function trip(){
        return $this->hasOneThrough(Trip::class, Pickup::class, 'id', 'trip_id', 'pickup_id');
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

    public function pickup(){
        return $this->hasOne(Pickup::class, 'id', 'pickup_id');
    }

    public function getStatusLabelAttribute(){
        return getParcelStatus($this->status);
    }
}
