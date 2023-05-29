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

    protected $fillable = ['total_tax', 'status', 'pickup_name', 'pickup_datetime', 'serve_by'];

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

    public function getStatusBadgeAttribute(){
        return PickupHelperService::statuseBadge()[$this->status] ?? __("Unknown Status");
    }

}
