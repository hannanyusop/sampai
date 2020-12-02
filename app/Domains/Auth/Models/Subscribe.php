<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model{

    protected $fillable = [];

    public function parcel(){

        return $this->hasOne(Parcels::class, 'tracking_no', 'tracking_no');
    }

}
