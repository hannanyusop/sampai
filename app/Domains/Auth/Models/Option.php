<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model{

    protected $fillable = [
        'name', 'value'
    ];
}
