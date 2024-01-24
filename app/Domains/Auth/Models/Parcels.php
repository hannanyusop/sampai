<?php
namespace App\Domains\Auth\Models;

use App\Models\Pickup;
use App\Services\Parcel\ParcelHelperService;
use App\Services\Pickup\PickupHelperService;
use App\Services\Trip\TripHelperService;
use App\Models\UnregisteredParcel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Parcels extends Model{

    protected $fillable = ['pickup_id', 'status', 'checked', 'service_charge', 'guni', 'cod_fee'];

    protected $appends = ['total_billing', 'status_label', 'price_formated', 'tax_formated', 'coding', 'gross_price', 'total_billing_formatted', 'invoice_path'];

    public function trip(){
        return $this->hasOneThrough(Trip::class, Pickup::class, 'id', 'id', 'pickup_id', 'trip_id');
    }

    public function transactions(){

        return $this->hasMany(ParcelTransaction::class, 'parcel_id', 'id')->orderBy('id', 'DESC');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getInvoicePathAttribute()
    {
        return  Storage::exists($this->invoice_url) ? asset($this->invoice_url) : 'https://placehold.co/600x400';
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

    public function getTotalBillingFormattedAttribute(){
        return displayPriceFormat($this->total_billing, '$');
    }

    public function unregisteredParcel(){
        return $this->hasOne(UnregisteredParcel::class, 'id', 'parcel_id');
    }

    public function getStatusLabelAttribute(){

        return ParcelHelperService::statuses($this->status);
    }

    public function getPriceFormatedAttribute(){
        return displayPriceFormat($this->price, 'RM');
    }

    public function getTaxFormatedAttribute(){
        return displayPriceFormat($this->tax, 'B$');
    }

    public function getCodingAttribute(){


        if(auth()->user()->type == User::TYPE_USER && !in_array($this->pickup?->status, [PickupHelperService::STATUS_READY_TO_DELIVER, PickupHelperService::STATUS_DELIVERED])){
            return __("- NOT READY -");
        }

        return ($this->pickup) ?  __(":pickup_code/:code", ['code' => $this->code, 'pickup_code' => $this?->pickup?->code]) : __("No Code");
    }
}
