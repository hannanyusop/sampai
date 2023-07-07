<?php
namespace App\Domains\Auth\Models;

use App\Models\Pickup;
use App\Services\Trip\TripHelperService;
use App\Models\UnregisteredParcel;
use Illuminate\Database\Eloquent\Model;

class Parcels extends Model{

    protected $fillable = ['pickup_id', 'status', 'checked', 'service_charge', 'guni'];

    protected $appends = ['total_billing'];

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

    public function getGrossPriceAttribute(){
        return $this->cod_fee + $this->service_charge;
    }

    public function getTotalBillingAttribute(){
        return $this->cod_fee + $this->service_charge + $this->tax + $this->permit;
    }

    public function unregisteredParcel(){
        return $this->hasOne(UnregisteredParcel::class, 'id', 'parcel_id');
    }

    public function getStatusLabelAttribute(){

        return TripHelperService::getStatuses($this->status);
    }

    public function getPriceFormatedAttribute(){
        return displayPriceFormat($this->price, 'RM');
    }

    public function getTaxFormatedAttribute(){
        return displayPriceFormat($this->tax, 'B$');
    }

    public function getCodingAttribute(){

        return ($this->pickup) ?  __(":pickup_code / :code", ['code' => $this->code, 'pickup_code' => $this?->pickup?->code]) : __("No Code");
    }
}
