<?php

namespace App\Services\Trip;

class TripHelperService
{
    const STATUS_PENDING = 1;
    const STATUS_CLOSED = 2;
    const STATUS_IN_TRANSIT = 3;
    const STATUS_ARRIVED = 4;
    const STATUS_DELIVERED = 5;

    public static function getStatuses($status = null){

        $statuses = [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_IN_TRANSIT => 'In Transit',
            self::STATUS_ARRIVED => 'Arrived',
            self::STATUS_DELIVERED => 'Delivered',
        ];

        return $status ? $statuses[$status] ?? "invalid status" : $statuses;
    }

}
