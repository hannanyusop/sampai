<?php

namespace App\Models;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Services\TripBatch\TripBatchHelperService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripBatch extends Model
{
    use HasFactory;

    # office_id

    protected $fillable = ['tax_rate', 'pos_rate', 'is_closed', 'created_by', 'office_id'];


    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function trips(){
        return $this->hasMany(Trip::class, 'trip_batch_id', 'id');
    }

    public function pickups(){
        return $this->hasManyThrough(Pickup::class, Trip::class, 'trip_batch_id', 'trip_id', 'id', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function parcels()
    {
        return $this->hasManyThrough(Parcels::class, Pickup::class, 'trip_id', 'pickup_id', 'id', 'id');
    }

    public function getStatusAttribute(){
        return  $this->trips()->first()->status;
    }

    public function getNumberAttribute(){
        return "#".str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusNameAttribute(){
        return TripBatchHelperService::getStatuses($this->status);
    }

    public function getTaxRateCurrencyAttribute(){
        return "B$ " . $this->tax_rate;
    }

    public function getPosRateCurrencyAttribute(){
        return "B$ " . $this->pos_rate;
    }
}
