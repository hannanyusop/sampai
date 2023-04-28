<?php
namespace App\Domains\Auth\Models;

use App\Models\Pickup;
use App\Services\Trip\TripHelperService;
use App\Models\UnregisteredParcel;
use Illuminate\Database\Eloquent\Model;

class Parcels extends Model{

    protected $fillable = ['pickup_id', 'status', 'checked'];

    public function trip(){
        return $this->hasOneThrough(Trip::class, Pickup::class, 'trip_id', 'id', 'pickup_id');
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

    public function unregisteredParcel(){
        return $this->hasOne(UnregisteredParcel::class, 'id', 'parcel_id');
    }

    public function getStatusLabelAttribute(){

        return TripHelperService::getStatuses($this->status);
    }
}
