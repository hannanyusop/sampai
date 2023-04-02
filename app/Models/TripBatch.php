<?php

namespace App\Models;

use App\Domains\Auth\Models\Parcels;
use App\Domains\Auth\Models\Trip;
use App\Domains\Auth\Models\User;
use App\Services\TripBatch\TripBatchHelperService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripBatch extends Model
{
    use HasFactory;


    public function trips(){
        return $this->hasMany(Trip::class, 'trip_batch_id', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function parcels()
    {
        return $this->hasManyThrough(Parcels::class, Trip::class, 'trip_batch_id', 'pickup_id', 'id', 'id');
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
}
