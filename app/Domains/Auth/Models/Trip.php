<?php
namespace App\Domains\Auth\Models;

use App\Models\Pickup;
use App\Models\TripBatch;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model{

    protected $fillable = [];

    public function batch(){
        return $this->hasOne(TripBatch::class, 'id', 'trip_batch_id');
    }

    public function getStatusAttribute(){
        return $this->batch->status;
    }

    public function destination(){
        return $this->hasOne(Office::class, 'id', 'destination_id');
    }

    public function parcels(){
        return $this->hasManyThrough(Parcels::class, Pickup::class);
    }

    public function transactions(){
        return $this->hasOne(Trip::class, 'id', 'trip_id');
    }

    public function remarks(){

        return $this->hasMany(TripRemark::class, 'trip_id', 'id');
    }

    public function office(){
        return $this->hasOne(Office::class, 'id', 'destination_id');
    }
}
