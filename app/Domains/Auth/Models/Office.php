<?php
namespace App\Domains\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model{

    protected $fillable = [
        'id',
        'code',
        'name',
        'is_drop_point',
        'is_receiver',
        'address',
    ];

    protected $appends = ['label'];

    public function manager(){



        $permissions = Permission::with('users')->where('name', 'staff.manager')->first();

        $str = "";
        foreach ($permissions->users as $user){

            if($user->office_id == $this->id){
                $str.= $user->name." ,";
            }
        }
        return $str;
    }

    public function parcels(){
        return $this->hasMany(Office::class);
    }

    public function pickups(){
        return $this->hasMany(Office::class);
    }

    public function getLabelAttribute(){
        return $this->code." - ".$this->name;
    }

}
