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

    public static function getTripStatusBadge($status = null){

        $statuses = [
            self::STATUS_PENDING => '<span class="badge badge-dot badge-dot-xs badge-secondary">Open</span>',
            self::STATUS_CLOSED=> '<span class="badge badge-dot badge-dot-xs badge-success" > Closed </span>',
            self::STATUS_IN_TRANSIT => '<span class="badge badge-dot badge-dot-xs badge-success" > In Transit </span>',
            self::STATUS_ARRIVED => '<span class="badge badge-dot badge-dot-xs badge-success" > Arrived </span>',
            self::STATUS_DELIVERED => '<span class="badge badge-dot badge-dot-xs badge-success" > Delivered </span>'
        ];

        return (is_null($status))? $statuses : $statuses[$status];

    }

}
