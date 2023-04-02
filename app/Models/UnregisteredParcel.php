<?php

namespace App\Models;

use App\Domains\Auth\Models\Parcels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnregisteredParcel extends Model
{
    use HasFactory;

    public function parcels(){
        return $this->hasOne(Parcels::class, 'id', 'parcel_id');
    }
}
