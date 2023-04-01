<?php

namespace App\Models;

use App\Domains\Auth\Models\Trip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripBatch extends Model
{
    use HasFactory;


    public function trips(){
        return $this->hasMany(Trip::class, 'trip_batch_id', 'id');
    }

    public function getNumberAttribute(){
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
