<?php

namespace App\Models;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Services\Pickup\PickupHelperService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pickup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['total_tax', 'status', 'pickup_name', 'pickup_datetime', 'serve_by',
        'payment_method', 'payment_status', 'total_payment', 'prof_of_delivery'
    ];

    public function parcels(){
        return $this->hasMany(Parcels::class, 'pickup_id', 'id');
    }

    public function dropPoint(){
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function trip(){
        return $this->belongsTo(Trip::class,  'trip_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pic(){
        return $this->belongsTo(User::class, 'serve_by', 'id');
    }

    public function getTotalAttribute(){
        return $this->parcels()->sum('cod_fee') + $this->parcels()->sum('service_charge') + $this->parcels()->sum('tax') + $this->parcels()->sum('permit');
    }

    public function getGrossPriceAttribute(){
        return $this->parcels()->sum('cod_fee') + $this->parcels()->sum('service_charge');
    }

    public function getPermitAttribute(){
        return $this->parcels()->sum('permit');
    }

    public function getTaxAttribute(){
        return $this->parcels()->sum('tax');
    }

    public function getServiceChargeAttribute(){
        return $this->parcels()->sum('service_charge');
    }

    public function getStatusBadgeAttribute(){
        return PickupHelperService::statuseBadge()[$this->status] ?? __("Unknown Status");
    }

    public function getStatusLabelAttribute(){
        return PickupHelperService::StatusLabel()[$this->status] ?? __("Unknown Status");
    }

    public function getPaymentMethodLabelAttribute(){
        return PickupHelperService::paymentMethodLabel()[$this->payment_method] ?? __("Unknown Payment Method");
    }

    public function getPaymentStatusLabelAttribute(){
        return PickupHelperService::paymentStatusLabel()[$this->payment_status] ?? __("Unknown Payment Status");
    }

}
