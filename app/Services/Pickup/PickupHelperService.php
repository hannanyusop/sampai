<?php

namespace App\Services\Pickup;

class PickupHelperService
{

    const STATUS_PENDING = 1, STATUS_READY_TO_DELIVER = 2, STATUS_DELIVERED = 3;

    public static function statuseBadge(){

        return [
            self::STATUS_PENDING   => '<span class="badge rounded-pill bg-warning">Pending</span>',
            self::STATUS_READY_TO_DELIVER => '<span class="badge rounded-pill bg-info">Ready to Deliver</span>',
            self::STATUS_DELIVERED => '<span class="badge rounded-pill bg-success">Delivered</span>'
        ];
    }

}
