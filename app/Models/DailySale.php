<?php

namespace App\Models;

use App\Domains\Auth\Models\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    use HasFactory;

    public function office(){
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function pickups(){
        return $this->hasMany(Pickup::class, 'daily_sale_id', 'id')->orderBy('created_at', 'desc');
    }

    public function getSalesReceivedBadgeAttribute()
    {
        return (is_null($this->deposit_received) ? '<div class="badge bg-danger rounded-pill text-white">Not Received</div>' : '<div class="badge bg-success rounded-pill text-dark">Received</div>');
    }
}
