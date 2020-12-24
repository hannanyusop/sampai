<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model{

    protected $fillable = [
        'id',
        'code',
        'name',
        'is_drop_point',
        'address',
    ];
}
