<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class TrackHistories extends Model{

    protected $fillable = [];

    public function user(){

        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
