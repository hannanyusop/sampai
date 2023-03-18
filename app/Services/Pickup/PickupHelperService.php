<?php

namespace App\Services\Pickup;

class PickupHelperService
{

    const STATUS_PENDING = 1, STATUS_DELIVERED = 2;

    public function statuses(){

        return [
            self::STATUS_PENDING   => 'Pending',
            self::STATUS_DELIVERED => 'Delivered'
        ];
    }

}
