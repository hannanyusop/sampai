<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelTransaction extends Model{

    protected $fillable = [];

    public function parcel(){

        return $this->hasOne(Parcels::class, 'id', 'parcel_id');
    }
}
