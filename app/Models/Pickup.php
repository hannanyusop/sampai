<?php

namespace App\Models;

use App\Domains\Auth\Models\Parcels;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pickup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['total_tax', 'status'];

    public function parcels(){
        return $this->hasMany(Parcels::class, 'pickup_id', 'id');
    }
}
